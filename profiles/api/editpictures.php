<?PHP
ini_set("display_errors", 1);
error_reporting(E_ALL);

require_once("../../database/accountFunctions.php");


$profilepic = array_key_exists("profilepic", $_POST)  // only for these you need to use that new file method instead of $_POST I think 
    ? $_POST["profilepic"]
    : null;
$banner = array_key_exists("banner", $_POST)
    ? $_POST["banner"]
    : null;

try {
    $headshot = storePic($profilepic); //need to design the storePic function to store the png or jpeg in the correct folder and then return the address or url of the pic to store in the database
    $ban = storePic($banner);
    editPictures($headshot, $ban);
} catch (Exception $e) {
    echo $e;
}
