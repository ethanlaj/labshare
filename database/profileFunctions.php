<?PHP
// Include connection
require_once "connect.php";
require_once "classes.php";
require_once "userFunctions.php";

ini_set("display_errors", 1);
error_reporting(E_ALL);


function createProfile($user_id,
$quals_degrees = null,
$areaOfStudy = null,
$yearsOfStudy = null,
$secondaryAreaOfStudy = null,
$about = null,
$achievements_interests = null)
{
	$sql = "INSERT INTO profiles (user_id,
    quals_degrees,
    areaOfStudy,
    yearsOfStudy,
    secondaryAreaOfStudy,
    about,
    achievements_interests)
          VALUES (:user_id,
		:quals_degrees,
		:areaOfStudy,
		:yearsOfStudy,
		:secondaryAreaOfStudy,
		:about,
		:achievements_interests)";


	$params =
		[
			":user_id" => $user_id,
			":quals_degrees" => $quals_degrees,
			":areaOfStudy" => $areaOfStudy,
			":yearsOfStudy" => $yearsOfStudy,
			":secondaryAreaOfStudy" => $secondaryAreaOfStudy,
            ":about" => $about,
            ":achievements_interests" => $achievements_interests,
		];

	try {
		postDataFromSQL($sql, $params);
	} catch (Exception $e) {
		header("HTTP/1.1 500 Fatal Error");
	}
}
