<?PHP
ini_set("display_errors", 1);
error_reporting(E_ALL);

//if (isset($_POST["user_id"])) {
require_once("../../database/profileFunctions.php");

//$user_id = $_POST["user_id"];
$user_id = 2;
$quals_degrees = null;
$areaOfStudy = null;
$yearsOfStudy = null;
$secondaryAreaOfStudy = null;
$about = null;
$achievements = null;
$achievements = array_key_exists("achievements_interests", $_POST)
    ? $_POST["achievements_interests"]
    : null;


if (array_key_exists("quals_degrees", $_POST))
    $quals_degrees = $_POST["quals_degrees"];
if (array_key_exists("areaOfStudy", $_POST))
    $areaOfStudy = $_POST["areaOfStudy"];
if (array_key_exists("yearsOfStudy", $_POST))
    $yearsOfStudy = $_POST["yearsOfStudy"];
if (array_key_exists("secondaryAreaOfStudy", $_POST))
    $secondaryAreaOfStudy = $_POST["secondaryAreaOfStudy"];
if (array_key_exists("about", $_POST))
    $about = $_POST["about"];

try {
    createProfile($user_id, $quals_degrees, $areaOfStudy, $yearsOfStudy, $secondaryAreaOfStudy, $about, $achievements);
} catch (Exception $e) {
    echo $e;
}

//} else {
	//header("HTTP/1.1 400 Invalid parameters");
//}
