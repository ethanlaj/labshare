<?PHP
// Include connection
require_once "connect.php";
require_once "classes.php";
require_once "userFunctions.php";


ini_set("display_errors", 1);
error_reporting(E_ALL);


function createProfile(
    $user_id,
    $quals_degrees = null,
    $areaOfStudy = null,
    $yearsOfStudy = null,
    $secondaryAreaOfStudy = null,
    $about = null,
    $achievements_interests = null,
    $fullName = null,
    $age = null,
    $profilePic = null,
    $banner = null
) {
    $sql = "INSERT INTO profiles (user_id,
    quals_degrees,
    areaOfStudy,
    yearsOfStudy,
    secondaryAreaOfStudy,
    about,
    achievements_interests,
    fullName,
    age,
    profilePic,
    banner)
          VALUES (:user_id,
		:quals_degrees,
		:areaOfStudy,
		:yearsOfStudy,
		:secondaryAreaOfStudy,
		:about,
		:achievements_interests,
        :fullName,
        :age,
        :profilePic,
        :banner)";


    $params =
        [
            ":user_id" => $user_id,
            ":quals_degrees" => $quals_degrees,
            ":areaOfStudy" => $areaOfStudy,
            ":yearsOfStudy" => $yearsOfStudy,
            ":secondaryAreaOfStudy" => $secondaryAreaOfStudy,
            ":about" => $about,
            ":achievements_interests" => $achievements_interests,
            ":fullName" => $fullName,
            ":age" => $age,
            ":profilePic" => $profilePic,
            ":banner" => $banner

        ];

    try {
        postDataFromSQL($sql, $params);
    } catch (Exception $e) {
        header("HTTP/1.1 500 Fatal Error");
    }
}


function fetchProfile()
{
    $sql = "SELECT * FROM profiles;";

    $prof = getDataFromSQL($sql)[0];


    return new Profile(4, $prof["quals_degrees"], $prof["areaOfStudy"], $prof["yearsOfStudy"], $prof["secondaryAreaOfStudy"], $prof["about"], $prof["achievements_interests"], $prof["fullName"], $prof["age"], $prof["profilePic"], $prof["banner"]);
}
