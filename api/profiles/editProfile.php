<?PHP
ini_set("display_errors", 1);
error_reporting(E_ALL);

require_once(__DIR__ . "/../../database/accountFunctions.php");


$quals_degrees = array_key_exists("qualifications", $_POST)
    ? $_POST["qualifications"]
    : null;
$areaOfStudy = array_key_exists("areaofstudy", $_POST)
    ? $_POST["areaofstudy"]
    : null;
$yearsOfStudy = array_key_exists("years", $_POST)
    ? $_POST["years"]
    : null;
$secondaryAreaOfStudy = array_key_exists("secondarea", $_POST)
    ? $_POST["secondarea"]
    : null;
$about = array_key_exists("summary", $_POST)
    ? $_POST["summary"]
    : null;
$achievements = array_key_exists("achievements", $_POST)
    ? $_POST["achievements"]
    : null;

try {
    createProfile($quals_degrees, $areaOfStudy, $yearsOfStudy, $secondaryAreaOfStudy, $about, $achievements);
} catch (Exception $e) {
    echo $e;
}
header("Location: ../../profiles/profile.php");
