<?PHP


require_once(__DIR__ . "/../../database/accountFunctions.php");


$userName = array_key_exists("userName", $_POST)
    ? $_POST["userName"]
    : null;
$pwd = array_key_exists("password", $_POST)
    ? $_POST["password"]
    : null;
$email = array_key_exists("email", $_POST)
    ? $_POST["email"]
    : null;
$phoneNumber = array_key_exists("phone", $_POST)
    ? $_POST["phone"]
    : null;

try {
    $pwd = password_hash($pwd, PASSWORD_DEFAULT);
    editAccount($userName, $pwd, $email, $phoneNumber);
} catch (Exception $e) {
    echo $e;
}
