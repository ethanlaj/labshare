<?PHP
ini_set("display_errors", 1);
error_reporting(E_ALL);

require_once("../../database/accountFunctions.php");
// header('Content-Type:image/jpeg'); //not sure if I need this

$profilepic = array_key_exists("profilepic", $_FILES)  // only for these you need to use that new file method instead of $_POST I think 
    ? $_FILES["profilepic"]
    : null;
print_r($profilepic);
$banner = array_key_exists("banner", $_FILES)
    ? $_FILES["banner"]
    : null;

try {



    //also tried ../../../CS10/profilepics
    // getting the tmp_name of the uploaded image
    $temp_name = $_FILES["profilepic"]["tmp_name"];
    $file_name = $_FILES["profilepic"]["name"];
    $image_dir = "/Applications/XAMPP/xamppfiles/htdocs/CS310/profilepics/" . $file_name;

    // using the move_uploaded_file function
    if (move_uploaded_file($temp_name, $image_dir)) {
        echo "success";
    } else
        echo "There was an error uploading file";




    // $filename = $_FILES["profilepic"]["full_path"];
    // echo $filename;
    // rename($filename, "../../../profilepics/profilepic.JPG");



    //  $target_dir = "~Applications/XAMPP/xamppfiles/htdocs/CS310/profilepics";
    //  $target_file = $target_dir . basename($_FILES["profilepic"]["name"]);
    // if (move_uploaded_file(
    //     $_FILES["profilepic"]["tmp_name"],
    //      $target_file
    // )) {
    //      echo "The file " . basename($_FILES["profilepic"]["name"])
    // /        . " has been uploaded.<br>";

    //     // Moving file to New directory 
    //     if (rename($target_file, "New/" .
    //         basename($_FILES["profilepic"]["name"]))) {
    //         echo "File moving operation success<br>";
    //     } else {
    //         echo "File moving operation failed..<br>";
    //     }
    // } else {
    //     echo "Sorry, there was an error uploading your file.<br>";
    // }


    // $headshot = storePic($profilepic); //need to design the storePic function to store the png or jpeg in the correct folder and then return the address or url of the pic to store in the database
    // $ban = storePic($banner);
    // editPictures($headshot, $ban);
} catch (Exception $e) {
    echo $e;
}
