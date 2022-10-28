<?PHP
// Include connection
require_once "connect.php";

// Include any classes that are needed
require_once "../classes/user.php";

ini_set("display_errors",1);
error_reporting(E_ALL);

function getUser($user_id) : User {
  $sql = "SELECT * FROM users WHERE user_id=:id";
  $params = [":id" => $user_id];

  $user = getDataFromSQL($sql, $params)[0];
  
  if ($user) {
    return new User($user["user_id"], $user["username"], $user["firstName"], $user["lastName"], $user["email"], $user["phoneNumber"], $user["birthday"], $user["inactive"]);
  }
  else return null;
}

?>