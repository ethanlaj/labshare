<?PHP
require_once(__DIR__ . "/../../global/validation.php");

if (isset($_POST["title"]) && isset($_POST["content"])) {
	require_once(__DIR__ . "/../../database/postFunctions.php");

	$title = $_POST["title"];
	$content = $_POST["content"];
	$zip = array_key_exists("zip", $_POST) ? (int) $_POST["zip"] : null;

	if (validateInput($patterns["postTitle"], $title) && validateInput($patterns["postContent"], $content) && validateInput($patterns["zip"], $zip)) {
		$new_post_id = createPost($title, $content, $zip ? $zip : null);

		if ($new_post_id)
			header("Location: ../../posting/post.php?id=$new_post_id");
		else
			header("Location: ../../posting/posts.html");
	} else header("Location: ../../posting/posts.html");
} else {
	header("HTTP/1.1 400 Invalid parameters");
}
