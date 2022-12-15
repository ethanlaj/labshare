<?PHP
require_once(__DIR__ . "/../../global/validation.php");

if (isset($_POST["post_id"]) && isset($_POST["content"]) && validate_input("comment", $_POST["content"])) {
	require_once(__DIR__ . "/../../database/postFunctions.php");

	$post_id = $_POST["post_id"];
	$content = $_POST["content"];
	$parent_id = null;

	if (array_key_exists("parent_id", $_POST))
		$parent_id = $_POST["parent_id"];

	addComment($post_id, $content, $parent_id);
} else {
	header("HTTP/1.1 400 Invalid parameters");
}
