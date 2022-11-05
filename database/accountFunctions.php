<?PHP
// Include connection
require_once "connect.php";
require_once "classes.php";
require_once "userFunctions.php";


ini_set("display_errors", 1);
error_reporting(E_ALL);


function createUser(
    $firstName = null,
    $lastName = null,
    $email = null,
    $username = null,
    $pwd = null,
    $phoneNumber = null,
    $birthday = null,
    $qualifications = null,
    $areaofstudy = null,
    $years = null,
    $secondarea = null
) {
    $sql = "INSERT INTO users (firstName,lastName, email, username, pwd, phoneNumber, birthday, qualifications, areaofstudy, years, secondarea)
          VALUES (:firstName,
		:lastName,
		:email,
		:username,
		:pwd,
		:phoneNumber,
        :birthday,
        :qualifications,
        :areaofstudy,
        :years,
        :secondarea
	)";


    $params =
        [
            ":firstName" => $firstName,
            ":lastName" => $lastName,
            ":email" => $email,
            ":username" => $username,
            ":pwd" => $pwd,
            ":phoneNumber" => $phoneNumber,
            ":birthday" => $birthday,
            ":qualifications" => $qualifications,
            ":areaofstudy" => $areaofstudy,
            ":years" => $years,
            ":secondarea" => $secondarea
        ];

    try {
        postDataFromSQL($sql, $params);
    } catch (Exception $e) {
        header("HTTP/1.1 500 Fatal Error");
    }
}

function get_user_login($username)
{
    $sql = "SELECT user_id, username, pwd FROM users WHERE username=:username";

    $params =
        [
            ":username" => $username,
        ];

    try {
        return getDataFromSQL($sql, $params)[0];
    } catch (Exception $e) {
        header("HTTP/1.1 500 Fatal Error");
    }
}
