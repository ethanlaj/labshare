<?PHP
ini_set("display_errors", 1);
error_reporting(E_ALL);

//if (isset($_POST["user_id"])) {
require_once("../../database/accountFunctions.php");

//$user_id = $_POST["user_id"];
$firstName = array_key_exists("firstName", $_POST)
    ? $_POST["firstName"]
    : null;
$lastName = array_key_exists("lastName", $_POST)
    ? $_POST["lastName"]
    : null;
$email = array_key_exists("email", $_POST)
    ? $_POST["email"]
    : null;
$username = array_key_exists("username", $_POST)
    ? $_POST["username"]
    : null;
$pwd = array_key_exists("pwd", $_POST)
    ? $_POST["pwd"]
    : null;
$phoneNumber = array_key_exists("phoneNumber", $_POST)
    ? $_POST["phoneNumber"]
    : null;
$birthday = array_key_exists("birthday", $_POST)
    ? $_POST["birthday"]
    : null;
$qualifications = array_key_exists("qualifications", $_POST)
    ? $_POST["qualifications"]
    : null;
$areaofstudy = array_key_exists("areaofstudy", $_POST)
    ? $_POST["areaofstudy"]
    : null;
$years = array_key_exists("years", $_POST)
    ? $_POST["years"]
    : null;
$secondarea = array_key_exists("secondarea", $_POST)
    ? $_POST["secondarea"]
    : null;


if ($firstName && $lastName && $email && $userName && $pwd && $birthday && $qualifications && $areaofstudy && $years && $secondarea) {
    try {
        $pwd = password_hash($pwd, PASSWORD_DEFAULT);

        createUser($firstName, $lastName, $email, $userName, $pwd, $phoneNumber, $birthday, $qualifications, $areaofstudy, $years, $secondarea);
    } catch (Exception $e) {
        echo $e;
    }
} else {
    header("HTTP/1.1 400 Invalid parameter");
    echo "You are missing a field";
}
