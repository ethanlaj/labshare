<?PHP
ini_set("display_errors", 1);
error_reporting(E_ALL);

require_once(__DIR__ . "/../../database/accountFunctions.php");
require_once('bucket_config.php');

try {
    if (isset($_FILES['profilepic']))
        call_upload_function('profilepic');
    if (isset($_FILES['banner']))
        call_upload_function('banner');

    header("Location: ../../profiles/profile.php");
} catch (Exception $e) {
    echo $e;
}

function call_upload_function($type)
{
    // Credit: Rajesh Kumar Sahanee on https://zatackcoder.com/upload-file-to-google-cloud-storage-using-php/ 

    if ($_FILES[$type]['error'] != 4) {
        //set which bucket to work in
        $bucketName = "user_pictures_folder";
        // get local file for upload testing
        $fileContent = file_get_contents($_FILES[$type]["tmp_name"]);
        // NOTE: if 'folder' or 'tree' is not exist then it will be automatically created !
        $exploded = explode(".", $_FILES[$type]["name"]);

        $file_extension = "." . $exploded[count($exploded) - 1];
        $new_name =  $_SESSION["user"] . $file_extension;
        $cloudPath = "{$type}s/" . $_SESSION["user"] . $file_extension;

        $isSucceed = uploadFile($bucketName, $fileContent, $cloudPath);

        if ($isSucceed == true)
            set_image_path($new_name, $type);

        return $isSucceed;
    }
}
