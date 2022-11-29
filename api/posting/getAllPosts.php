<?PHP
ini_set("display_errors", 1);
error_reporting(E_ALL);

header("Content-Type: application/json");

require_once("../../database/postFunctions.php");

$type = isset($_GET["type"]) ? $_GET["type"] : null;
$search = isset($_GET["search"]) ? $_GET["search"] : null;

$posts = getPosts($type, $search);

echo json_encode($posts);
