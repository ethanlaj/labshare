<?PHP
ini_set("display_errors", 1);
error_reporting(E_ALL);

header("Content-Type: application/json");

require_once("../../database/postFunctions.php");

$type = isset($_GET["type"]) ? $_GET["type"] : null;

$posts = getPosts($type);

echo json_encode($posts);
