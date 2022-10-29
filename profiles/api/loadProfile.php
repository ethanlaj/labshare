<?PHP
ini_set("display_errors", 1);
error_reporting(E_ALL);

header("Content-Type: application/json");

require_once("../../database/profileFunctions.php");

$profile = getPosts();

echo json_encode($posts);
