<?PHP
require_once(__DIR__ . "/../../global/validation.php");

if (isset($_POST["post_id"]) && isset($_POST["title"]) && isset($_POST["content"])) {
	require_once(__DIR__ . "/../../database/postFunctions.php");

	$post_id = $_POST["post_id"];
	$title = $_POST["title"];
	$content = $_POST["content"];
	$zip = array_key_exists("zip", $_POST) ? (int) $_POST["zip"] : null;

	if (validateInput($patterns["postTitle"], $title) && validateInput($patterns["postContent"], $content) && validateInput($patterns["zip"], $zip))
		editPost($post_id, $title, $content, $zip ? $zip : null);

	header("Location: ../../posting/post.php?id=$post_id");
	die();
} else {
	header("HTTP/1.1 400 Invalid parameters");
}
