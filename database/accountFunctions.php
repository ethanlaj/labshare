<?PHP
// Include connection
require_once "connect.php";
require_once "classes.php";
require_once "userFunctions.php";


ini_set("display_errors", 1);
error_reporting(E_ALL);


function createUser(
    $firstName,
    $lastName,
    $email,
    $userName,
    $pwd,
    $phoneNumber,
    $birthday
) {
    $sql = "INSERT INTO users (firstName,lastName, email, username, pwd, phoneNumber, birthday)
          VALUES (:firstName,
		:lastName,
		:email,
		:username,
		:pwd,
		:phoneNumber,
        :birthday
	);";


    $params =
        [
            ":firstName" => $firstName,
            ":lastName" => $lastName,
            ":email" => $email,
            ":username" => $userName,
            ":pwd" => $pwd,
            ":phoneNumber" => $phoneNumber,
            ":birthday" => $birthday
        ];

    try {
        postDataFromSQL($sql, $params);
    } catch (Exception $e) {
        header("HTTP/1.1 500 Fatal Error");
    }
}

function get_user_login($userName)
{
    $sql = "SELECT user_id, username, pwd FROM users WHERE username=:username";

    $params =
        [
            ":username" => $userName,
        ];

    try {
        return getDataFromSQL($sql, $params)[0];
    } catch (Exception $e) {
        header("HTTP/1.1 500 Fatal Error");
    }
}

function createProfile($qualifications = null, $areaofstudy = null, $years = null, $secondarea = null, $summary = null, $achievements = null)
{
    if (!isset($_SESSION["user"]))
        return header("HTTP/1.1 401 Unauthorized");

    $current_user_id = $_SESSION["user"];
    $sql = "UPDATE users SET qualifications= :qualifications, areaofstudy = :areaofstudy, years = :years, secondarea = :secondarea, summary = :summary, achievements = :achievements
    WHERE user_id = $current_user_id";


    $params =
        [
            ":qualifications" => $qualifications,
            ":areaofstudy" => $areaofstudy,
            ":years" => $years,
            ":secondarea" => $secondarea,
            ":summary" => $summary,
            ":achievements" => $achievements,
        ];

    try {
        postDataFromSQL($sql, $params);
    } catch (Exception $e) {
        header("HTTP/1.1 500 Fatal Error");
    }
}

function getCollabs()
{
    $current_user_id = $_SESSION["user"];
    $sql = "SELECT status, applicant_id, applicant_username, applicant_pic, poster_id, poster_username, posterpic FROM advanced_application WHERE status != 'DECLINE' AND (poster_id= $current_user_id OR applicant_id = $current_user_id)";
    $collabposts = getDataFromSQL($sql);
    if (count($collabposts) == 0)
        return null;
    $collabs = $collabposts[0];
    if ($collabs) {
        return new Collabs($collabs);
    } else return null;
}

function getprofile()
{
    $current_user_id = $_SESSION["user"];
    $sql = "SELECT qualifications, areaofstudy, years, secondarea, summary, achievements, profilepic, banner, firstName, lastName FROM users
    WHERE user_id = $current_user_id;";


    $prof = getDataFromSQL($sql);

    if (count($prof) == 0)
        return null;

    $profile = $prof[0];
    if ($profile) {
        return new User($profile);
    } else return null;
}
function accountinfo()
{
    $current_user_id = $_SESSION["user"];
    $sql = "SELECT username, email, phoneNumber FROM users
    WHERE user_id = $current_user_id;";


    $account = getDataFromSQL($sql);

    if (count($account) == 0)
        return null;

    $myaccount = $account[0];
    if ($myaccount) {
        return new User($myaccount);
    } else return null;
}
function editAccount($userName = null, $pwd = null, $email = null, $phoneNumber = null)
{
    if (!isset($_SESSION["user"]))
        return header("HTTP/1.1 401 Unauthorized");

    $current_user_id = $_SESSION["user"];
    $sql = "UPDATE users SET username= :username, pwd = :pwd, email = :email, phoneNumber = :phoneNumber
    WHERE user_id = $current_user_id";


    $params =
        [
            ":username" => $userName,
            ":pwd" => $pwd,
            ":email" => $email,
            ":phoneNumber" => $phoneNumber

        ];

    try {
        postDataFromSQL($sql, $params);
    } catch (Exception $e) {
        header("HTTP/1.1 500 Fatal Error");
    }
}

function updateprofilepic($profilepic)
{
    if (!isset($_SESSION["user"]))
        return header("HTTP/1.1 401 Unauthorized");
    $current_user_id = $_SESSION["user"];
    $sql = "UPDATE users SET profilepic= :profilepic
    WHERE user_id = $current_user_id";


    $params =
        [
            ":profilepic" => $profilepic
        ];

    try {
        postDataFromSQL($sql, $params);
    } catch (Exception $e) {
        header("HTTP/1.1 500 Fatal Error");
    }
}
function updatebanner($banner)
{
    if (!isset($_SESSION["user"]))
        return header("HTTP/1.1 401 Unauthorized");
    $current_user_id = $_SESSION["user"];
    $sql = "UPDATE users SET banner= :banner
    WHERE user_id = $current_user_id";


    $params =
        [
            ":banner" => $banner
        ];

    try {
        postDataFromSQL($sql, $params);
    } catch (Exception $e) {
        header("HTTP/1.1 500 Fatal Error");
    }
}
