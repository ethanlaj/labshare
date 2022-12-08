<?PHP
header("Content-type: application/json");

$output = array();
$password;
require(__DIR__ . "/../../database/accountFunctions.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


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
$pwd = array_key_exists("password", $_POST) && $_POST["password"] != ""
    ? $_POST["password"]
    : null;
$phone = array_key_exists("phone", $_POST)
    ? $_POST["phone"]
    : null;
$birthday = array_key_exists("birthday", $_POST)
    ? $_POST["birthday"]
    : null;


$current_user_id = isset($_SESSION["user"])
    ? $_SESSION["user"] : null;

if ($current_user_id) {
    $hashedpass = get_hashed_password($current_user_id);
} else echo "restricted";

$hash = $hashedpass["pwd"];
$is_pwd_correct = password_verify($_POST["oldpassword"], $hash);

$current_user = accountinfo();

if ($userName == $current_user->username) {
    $output["username_taken"] = false;
} else {
    $output["username_taken"] = check_matching_username($userName);
}
if ($is_pwd_correct) {
    $output["password_verify"] = true;
} else $output["password_verify"] = false;

if ($is_pwd_correct && !$output["username_taken"]) {
    try {
        $pwd = $pwd ? password_hash($pwd, PASSWORD_DEFAULT) : null;

        editAccount($userName, $email, $phone, $birthday, $firstName, $lastName, $pwd);
        $output["success"] = true;
    } catch (Exception $e) {
        echo $e;
    }
} else {
    $output["success"] = false;
}
echo json_encode($output);
