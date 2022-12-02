<?PHP
session_start();
if (!isset($_SESSION["user"]))
    return header("HTTP/1.1 401 Unauthorized");

require_once(__DIR__ . "/../../database/accountFunctions.php");
require_once('bucket_config.php');

$valid_types = array(".png", ".PNG", ".jpg", ".JPG", ".jpeg", ".JPEG");

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
    $exploded = explode(".", $_FILES[$type]["name"]);
    $file_extension = "." . $exploded[count($exploded) - 1];
    $max_size = 8388608;

    global $valid_types;
    if ($_FILES[$type]['size'] > $max_size || array_search($file_extension, $valid_types) === FALSE) {
        return; // error page?
    }

    // Credit: Rajesh Kumar Sahanee on https://zatackcoder.com/upload-file-to-google-cloud-storage-using-php/ 

    if ($_FILES[$type]['error'] != 4) {
        //set which bucket to work in
        $bucketName = "user_pictures_folder";
        // get local file for upload testing
        $fileContent = file_get_contents($_FILES[$type]["tmp_name"]);
        // NOTE: if 'folder' or 'tree' is not exist then it will be automatically created !

        $new_name =  $_SESSION["user"] . $file_extension;
        $cloudPath = "{$type}s/" . $_SESSION["user"] . $file_extension;

        $isSucceed = uploadFile($bucketName, $fileContent, $cloudPath);

        if ($isSucceed == true)
            set_image_path($new_name, $type);

        return $isSucceed;
    }
}
