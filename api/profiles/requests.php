<?php
// Credit: Rajesh Kumar Sahanee on https://zatackcoder.com/upload-file-to-google-cloud-storage-using-php/ 

include_once 'config.php';

$action = filter_var(trim($_REQUEST['action']), FILTER_SANITIZE_STRING);
if ($action == 'upload') {
	$response['code'] = "200";
	if ($_FILES['file']['error'] != 4) {
		//set which bucket to work in
		$bucketName = "user_pictures_folder";
		// get local file for upload testing
		$fileContent = file_get_contents($_FILES["file"]["tmp_name"]);
		// NOTE: if 'folder' or 'tree' is not exist then it will be automatically created !
		$cloudPath = 'uploads/' . $_FILES["file"]["name"];

		$isSucceed = uploadFile($bucketName, $fileContent, $cloudPath);

		if ($isSucceed == true) {
			$response['msg'] = 'SUCCESS: to upload ' . $cloudPath . PHP_EOL;
			// TEST: get object detail (filesize, contentType, updated [date], etc.)
			$response['data'] = getFileInfo($bucketName, $cloudPath);
		} else {
			$response['code'] = "201";
			$response['msg'] = 'FAILED: to upload ' . $cloudPath . PHP_EOL;
		}
	}
	header("Content-Type:application/json");
	echo json_encode($response);
	exit();
}
