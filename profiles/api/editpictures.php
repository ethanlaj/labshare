<?PHP
ini_set("display_errors", 1);
error_reporting(E_ALL);

require_once("../../database/accountFunctions.php");


try {

    if (isset($_FILES['profilepic'])) {
        $temp_name = $_FILES["profilepic"]["tmp_name"];
        $file_name = $_FILES["profilepic"]["name"];
        $image_dir = "/Applications/XAMPP/xamppfiles/htdocs/CS310/profilepics/$file_name";
        if (move_uploaded_file($temp_name, $image_dir)) {
            updateprofilepic("../../profilepics/$file_name");
        } else
            echo "There was an error uploading file";
    }
    if (isset($_FILES['banner'])) {
        $temp_name2 = $_FILES["banner"]["tmp_name"];
        $file_name2 = $_FILES["banner"]["name"];
        $image_dir2 = "/Applications/XAMPP/xamppfiles/htdocs/CS310/banners/$file_name2";
        if (move_uploaded_file($temp_name2, $image_dir2)) {
            updatebanner("../../banners/$file_name2");
        } else
            echo "There was an error uploading file";
    }
} catch (Exception $e) {
    echo $e;
}
header("Location: ../yourProfile.php");
