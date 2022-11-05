<?PHP
ini_set("display_errors", 1);
error_reporting(E_ALL);

//if (isset($_POST["user_id"])) {
require_once("../../database/profileFunctions.php");

//$user_id = $_POST["user_id"];
$user_id = 4;
$quals_degrees = array_key_exists("qualifications", $_POST)
    ? $_POST["qualifications"]
    : null;
$areaOfStudy = array_key_exists("areaofstudy", $_POST)
    ? $_POST["areaofstudy"]
    : null;
$yearsOfStudy = array_key_exists("years", $_POST)
    ? $_POST["years"]
    : null;
$secondaryAreaOfStudy = array_key_exists("secondfield", $_POST)
    ? $_POST["secondfield"]
    : null;
$about = array_key_exists("summary", $_POST)
    ? $_POST["summary"]
    : null;
$achievements = array_key_exists("achievements", $_POST)
    ? $_POST["achievements"]
    : null;
$fullName = array_key_exists("fullName", $_POST)
    ? $_POST["fullName"]
    : null;
$age = array_key_exists("age", $_POST)
    ? $_POST["age"]
    : null;
$profilePic = array_key_exists("profilePic", $_POST)
    ? $_POST["profilePic"]
    : null;
$banner = array_key_exists("banner", $_POST)
    ? $_POST["banner"]
    : null;

var_dump($_FILES);


try {
    createProfile($user_id, $quals_degrees, $areaOfStudy, $yearsOfStudy, $secondaryAreaOfStudy, $about, $achievements, $fullName, $age, $profilePic, $banner);
} catch (Exception $e) {
    echo $e;
}
