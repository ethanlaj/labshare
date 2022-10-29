<?PHP
// Include connection
require_once "connect.php";
require_once "classes.php";
require_once "userFunctions.php";

ini_set("display_errors", 1);
error_reporting(E_ALL);

function getPost($post_id)
{
	$sql = "SELECT * FROM posts WHERE inactive=0 AND post_id=:id";
	$params = [":id" => $post_id];

	$posts = getDataFromSQL($sql, $params);

	if (count($posts) == 0)
		return null;

	$post = $posts[0];
	if ($post) {
		return new Post($post["post_id"], $post["creationDate"], $post["author_id"], $post["title"], $post["content"], $post["reports"], $post["inactive"]);
	} else return null;
}

function getPosts(): array
{
	$sql = "SELECT * FROM posts WHERE inactive=0";

	$posts = getDataFromSQL($sql);

	$post_array = array();

	foreach ($posts as $post) {
		array_push($post_array, new Post($post["post_id"], $post["creationDate"], $post["author_id"], $post["title"], $post["content"], $post["reports"], $post["inactive"]));
	}

	return $post_array;
}

function getCommentsForPost($post_id): array
{
	$sql = "SELECT * FROM comments WHERE inactive=0 AND post_id=:id";
	$params = [":id" => $post_id];

	$comments = getDataFromSQL($sql, $params);

	$comment_array = array();

	foreach ($comments as $comment) {
		array_push($comment_array, new Comment($comment["comment_id"], $comment["post_id"], $comment["author_id"], $comment["creationDate"], $comment["parent_id"], $comment["content"], $comment["reports"], $comment["inactive"]));
	}

	return $comment_array;
}

function getRepliesToComment($comment_id): array
{
	$sql = "SELECT * FROM comments WHERE inactive=0 AND parent_id=:id";
	$params = [":id" => $comment_id];

	$comments = getDataFromSQL($sql, $params);

	$comment_array = array();

	foreach ($comments as $comment) {
		array_push($comment_array, new Comment($comment["comment_id"], $comment["post_id"], $comment["author_id"], $comment["creationDate"], $comment["parent_id"], $comment["content"], $comment["reports"], $comment["inactive"]));
	}

	return $comment_array;
}

function addComment($post_id, $content, $parent_id = null)
{
	$sql = "INSERT INTO comments (post_id, author_id, creationDate, content, parent_id)
          VALUES (:post_id, :author_id, :creationDate, :content, :parent_id)";

	// Use 24 as the default id until we have session data
	$author_id = 24;

	$params =
		[
			":post_id" => $post_id,
			":author_id" => $author_id,
			":creationDate" => date('Y-m-d H:i:s'),
			":content" => $content,
			":parent_id" => isset($parent_id) ? $parent_id : null,
		];

	try {
		postDataFromSQL($sql, $params);
	} catch (Exception $e) {
		header("HTTP/1.1 500 Fatal Error");
	}
}
