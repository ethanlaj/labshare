<?PHP
ini_set("display_errors", 1);
error_reporting(E_ALL);

header("Location: ../posts.html");

if (isset($_POST["title"]) && isset($_POST["content"])) {
	require_once("../../database/postFunctions.php");

	$title = $_POST["title"];
	$content = $_POST["content"];
	$zip = array_key_exists("zip", $_POST) ? (int) $_POST["zip"] : null;

	$new_post_id = createPost($title, $content, $zip ? $zip : null);

	if ($new_post_id)
		header("Location: ../post.php?id=$new_post_id");
} else {
	header("HTTP/1.1 400 Invalid parameters");
}
