<?PHP
header("Content-type: application/json");

session_start();
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
$phoneNumber = array_key_exists("phone", $_POST)
    ? $_POST["phone"]
    : null;
$birthday = array_key_exists("birthday", $_POST)
    ? $_POST["birthday"]
    : null;

$output = array("creation_successful" => false);

$output["username_taken"] = check_matching_username($userName);

if (!$output["username_taken"]) {
    if ($firstName && $lastName && $email && $userName && $pwd && $birthday) {
        try {
            $pwd = password_hash($pwd, PASSWORD_DEFAULT);

            $id = createUser($firstName, $lastName, $email, $userName, $pwd, $phoneNumber, $birthday);
            if ($id)
                $_SESSION["user"] = $id;

            $output["creation_successful"] = $id != null;
        } catch (Exception $e) {
            echo $e;
        }
    } else {
        header("HTTP/1.1 400 Missing Parameters");
    }
}

echo json_encode($output);
