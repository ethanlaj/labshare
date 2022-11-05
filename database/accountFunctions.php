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
    $birthday,
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

function updatePictures($profilepic = null, $banner = null)
{
    $sql = "INSERT INTO users (profilepic, banner)
          VALUES (:profilepic,
		:banner
	
	)";


    $params =
        [
            ":profilepic" => $profilepic,
            ":banner" => $banner

        ];

    try {
        postDataFromSQL($sql, $params);
    } catch (Exception $e) {
        header("HTTP/1.1 500 Fatal Error");
    }
}

function createProfile($qualifications = null, $areaofstudy = null, $years = null, $secondarea = null)
{
    $sql = "INSERT INTO users (qualifications, areaofstudy, years, secondarea)
    VALUES (:qualifications,
  :areaofstudy, :years, :secondarea

)";


    $params =
        [
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
