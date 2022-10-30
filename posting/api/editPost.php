<?PHP
ini_set("display_errors", 1);
error_reporting(E_ALL);

if (isset($_POST["post_id"]) && isset($_POST["title"]) && isset($_POST["content"])) {
	require_once("../../database/postFunctions.php");

	$post_id = $_POST["post_id"];
	$title = $_POST["title"];
	$content = $_POST["content"];
	$zip = array_key_exists("zip", $_POST) ? (int) $_POST["zip"] : null;

	editPost($post_id, $title, $content, $zip ? $zip : null);
	header("Location: ../post.php?id=$post_id");
	die();
} else {
	header("HTTP/1.1 400 Invalid parameters");
}
