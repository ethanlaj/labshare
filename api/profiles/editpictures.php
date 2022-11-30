<?PHP
ini_set("display_errors", 1);
error_reporting(E_ALL);

require_once(__DIR__ . "/../../database/accountFunctions.php");

try {

    if (isset($_FILES['profilepic'])) {
        $temp_name = $_FILES["profilepic"]["tmp_name"];
        $file_name = $_FILES["profilepic"]["name"];
        $image_dir = __DIR__ . "/../../profilepics/$file_name";
        if (move_uploaded_file($temp_name, $image_dir)) {
            updateprofilepic(__DIR__ . "/../../profilepics/$file_name");
        } else
            echo "There was an error uploading file";
    }
    if (isset($_FILES['banner'])) {
        $temp_name2 = $_FILES["banner"]["tmp_name"];
        $file_name2 = $_FILES["banner"]["name"];
        $image_dir2 = __DIR__ . "/../../banners/$file_name2";
        if (move_uploaded_file($temp_name2, $image_dir2)) {
            updatebanner(__DIR__ . "/../../banners/$file_name2");
        } else
            echo "There was an error uploading file";
    }
} catch (Exception $e) {
    echo $e;
}
header("Location: ../../profiles/profile.php");
