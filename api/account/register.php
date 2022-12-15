<?PHP
require_once(__DIR__ . "/../../global/validation.php");
header("Content-type: application/json");
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once(__DIR__ . "/../../database/accountFunctions.php");


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
$pwd2 = array_key_exists("password2", $_POST)
    ? $_POST["password2"]
    : null;
$phoneNumber = array_key_exists("phone", $_POST)
    ? $_POST["phone"]
    : null;
$birthday = array_key_exists("birthday", $_POST)
    ? $_POST["birthday"]
    : null;

$output = array("creation_successful" => false);

$output["username_taken"] = check_matching_username($userName);

if (!$output["username_taken"]) {
    if ($firstName && $lastName && $email && $userName && $pwd && $pwd2 && $birthday) {
        if (validate_input("firstName", $firstName) && validate_input("lastName", $lastName) && validate_input("email", $email) && validate_input("username", $userName) && validate_input("password", $pwd) && validate_input("phone", $phoneNumber) && validate_input("birthday", $birthday)) {
            try {
                $pwd = password_hash($pwd, PASSWORD_DEFAULT);

                $id = createUser($firstName, $lastName, $email, $userName, $pwd, $phoneNumber, $birthday);
                if ($id)
                    $_SESSION["user"] = $id;

                $output["creation_successful"] = $id != null;
            } catch (Exception $e) {
                // echo $e;
            }
        } else {
            header("HTTP/1.1 400 Parameter(s) Failed Validation");
        };
    } else {
        header("HTTP/1.1 400 Missing Parameters");
    }
}

echo json_encode($output);
