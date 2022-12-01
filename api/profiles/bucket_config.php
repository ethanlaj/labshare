<?php
// Credit: Rajesh Kumar Sahanee on https://zatackcoder.com/upload-file-to-google-cloud-storage-using-php/

// load GCS library
require_once '../../vendor/autoload.php';

use Google\Cloud\Storage\StorageClient;

// Please use your own private key (JSON file content) which was downloaded in step 3 and copy it here
// your private key JSON structure should be similar like dummy value below.
// WARNING: this is only for QUICK TESTING to verify whether private key is valid (working) or not.  
// NOTE: to create private key JSON file: https://console.cloud.google.com/apis/credentials  
$privateKeyFileContent = getenv("SERVICE_ACCOUNT_PRIVATE_KEY");

/*
 * NOTE: if the server is a shared hosting by third party company then private key should not be stored as a file,
 * may be better to encrypt the private key value then store the 'encrypted private key' value as string in database,
 * so every time before use the private key we can get a user-input (from UI) to get password to decrypt it.
 */

function uploadFile($bucketName, $fileContent, $cloudPath)
{
	$privateKeyFileContent = $GLOBALS['privateKeyFileContent'];
	// connect to Google Cloud Storage using private key as authentication
	try {
		$storage = new StorageClient([
			'keyFile' => json_decode($privateKeyFileContent, true)
		]);
	} catch (Exception $e) {
		// maybe invalid private key ?
		return false;
	}

	// set which bucket to work in
	$bucket = $storage->bucket($bucketName);

	// upload/replace file 
	$storageObject = $bucket->upload(
		$fileContent,
		['name' => $cloudPath]
		// if $cloudPath is existed then will be overwrite without confirmation
		// NOTE: 
		// a. do not put prefix '/', '/' is a separate folder name  !!
		// b. private key MUST have 'storage.objects.delete' permission if want to replace file !
	);

	// is it succeed ?
	return $storageObject != null;
}
