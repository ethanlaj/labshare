<?PHP
require_once('../../global/validation.php');

if (isset($_POST["comment_id"]) && isset($_POST["content"]) && validateInput($patterns["comment"], $_POST["content"])) {
	require_once("../../database/postFunctions.php");

	$comment_id = $_POST["comment_id"];
	$content = $_POST["content"];

	editComment($comment_id, $content);
} else {
	header("HTTP/1.1 400 Invalid parameters");
}
