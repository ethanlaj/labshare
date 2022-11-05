<?PHP
// Include connection
require_once "connect.php";
require_once "classes.php";

ini_set("display_errors", 1);
error_reporting(E_ALL);

// function getUser($user_id)
// {
//   $sql = "SELECT * FROM users WHERE user_id=:id";
//   $params = [":id" => $user_id];

//   $users = getDataFromSQL($sql, $params);

//   if (count($users) == 0)
//     return null;

//   $user = $users[0];

//   if ($user) {
//     return new User($user["user_id"], $user["username"], $user["firstName"], $user["lastName"], $user["email"], $user["phoneNumber"], $user["birthday"], $user["qualifications"], $areaofstudy["areaofstudy"], $years["years"], $user["inactive"]);
//   } else return null;
// }
