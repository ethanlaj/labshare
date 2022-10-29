<?PHP
ini_set("display_errors", 1);
error_reporting(E_ALL);

if (isset($_POST["post_id"]) && isset($_POST["content"])) {
	require_once("../../database/postFunctions.php");

	$post_id = $_POST["post_id"];
	$content = $_POST["content"];
	$parent_id = null;

	if (array_key_exists("parent_id", $_POST))
		$parent_id = $_POST["parent_id"];

	addComment($post_id, $content, $parent_id);
} else {
	header("HTTP/1.1 400 Invalid parameters");
}
