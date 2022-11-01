<?PHP
ini_set("display_errors", 1);
error_reporting(E_ALL);

if (isset($_POST["title"]) && isset($_POST["content"])) {
	require_once("../../database/postFunctions.php");

	$title = $_POST["title"];
	$content = $_POST["content"];
	$zip = array_key_exists("zip", $_POST) ? (int) $_POST["zip"] : null;

	createPost($title, $content, $zip ? $zip : null);
} else {
	header("HTTP/1.1 400 Invalid parameters");
}
