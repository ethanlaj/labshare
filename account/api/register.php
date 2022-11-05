<?PHP
ini_set("display_errors", 1);
error_reporting(E_ALL);
require_once("../../database/accountFunctions.php");


$firstName = array_key_exists("firstName", $_POST)
    ? $_POST["firstName"]
    : null;
$lastName = array_key_exists("lastName", $_POST)
    ? $_POST["lastName"]
    : null;
$email = array_key_exists("email", $_POST)
    ? $_POST["email"]
    : null;
$userName = array_key_exists("userName", $_POST)
    ? $_POST["userName"]
    : null;
$pwd = array_key_exists("password", $_POST)
    ? $_POST["password"]
    : null;
$phoneNumber = array_key_exists("phone", $_POST)
    ? (int)$_POST["phone"]
    : null;
$birthday = array_key_exists("birthday", $_POST)
    ? $_POST["birthday"]
    : null;


try {
    $pwd = password_hash($pwd, PASSWORD_DEFAULT);
    echo $birthday;
    createUser($firstName, $lastName, $email, $userName, $pwd, $phoneNumber, $birthday);
} catch (Exception $e) {
    echo $e;
}
