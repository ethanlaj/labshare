<?PHP
// Include connection
require_once "connect.php";
require_once "classes.php";
require_once "userFunctions.php";

ini_set("display_errors", 1);
error_reporting(E_ALL);

function convertToLocal($datetime)
{
	date_default_timezone_set("America/New_York");

	$time = strtotime($datetime . ' UTC');
	$dateInLocal = date('m/d/Y \a\t g:ia', $time);

	return $dateInLocal;
}

function getPost($post_id)
{
	$sql = "SELECT post_id,creationDate,title,content,username,author_id FROM post_with_username WHERE inactive=0 AND post_id=:id";
	$params = [":id" => $post_id];

	$posts = getDataFromSQL($sql, $params);

	if (count($posts) == 0)
		return null;

	$post = $posts[0];
	if ($post) {
		return new Post($post, true);
	} else return null;
}

function createPost($title, $content, $zip)
{
	$sql = "INSERT INTO posts (author_id, title, content, zip)
	VALUES (:author_id, :title, :content, :zip)";

	// Use 2 as the default id until we have session data
	$author_id = 2;

	$params = [
		":author_id" => $author_id,
		":title" => $title,
		":content" => $content,
		":zip" => $zip
	];

	try {
		postDataFromSQL($sql, $params);
	} catch (Exception $e) {
		header("HTTP/1.1 500 Fatal Error");
	}
}

function editPost($post_id, $title, $content, $zip)
{
	$sql = "UPDATE posts 
	SET title=:title, content=:content, zip=:zip
	WHERE post_id=:post_id";

	$params = [
		":post_id" => $post_id,
		":title" => $title,
		":content" => $content,
		":zip" => $zip
	];

	try {
		postDataFromSQL($sql, $params);
	} catch (Exception $e) {
		header("HTTP/1.1 500 Fatal Error");
	}
}

function deletePost($post_id)
{
	$sql = "UPDATE posts 
	SET inactive=1
	WHERE post_id=:post_id";

	$params = [":post_id" => $post_id];

	try {
		postDataFromSQL($sql, $params);
	} catch (Exception $e) {
		header("HTTP/1.1 500 Fatal Error");
	}
}

function getPosts(): array
{
	$sql = "SELECT post_id,creationDate,title,username,author_id,zip FROM post_with_username WHERE inactive=0";

	$posts = getDataFromSQL($sql);

	$post_array = array();

	foreach ($posts as $post)
		array_push($post_array, new Post($post));

	return $post_array;
}

function getCommentsForPost($post_id): array
{
	$sql = "SELECT comment_id,author_id,creationDate,parent_id,content,username FROM comment_with_username WHERE inactive=0 AND post_id=:id";
	$params = [":id" => $post_id];

	$comments = getDataFromSQL($sql, $params);

	$comment_array = array();

	foreach ($comments as $comment)
		array_push($comment_array, new Comment($comment));

	return $comment_array;
}

function getRepliesToComment($comment_id): array
{
	$sql = "SELECT comment_id,author_id,creationDate,parent_id,content,username FROM comment_with_username WHERE inactive=0 AND parent_id=:id";
	$params = [":id" => $comment_id];

	$comments = getDataFromSQL($sql, $params);

	$comment_array = array();

	foreach ($comments as $comment)
		array_push($comment_array, new Comment($comment));

	return $comment_array;
}

function addComment($post_id, $content, $parent_id = null)
{
	$sql = "INSERT INTO comments (post_id, author_id, content, parent_id)
          VALUES (:post_id, :author_id, :content, :parent_id)";

	// Use 2 as the default id until we have session data
	$author_id = 2;

	$params =
		[
			":post_id" => $post_id,
			":author_id" => $author_id,
			":content" => $content,
			":parent_id" => isset($parent_id) ? $parent_id : null,
		];

	try {
		postDataFromSQL($sql, $params);
	} catch (Exception $e) {
		header("HTTP/1.1 500 Fatal Error");
	}
}

function apply($post_id)
{
	$sql = "INSERT INTO applications (post_id, user_id)
          VALUES (:post_id, :user_id)";

	// Use 2 as the default id until we have session data
	$user_id = 2;

	$params =
		[
			":post_id" => $post_id,
			":user_id" => $user_id,
		];

	try {
		postDataFromSQL($sql, $params);
	} catch (Exception $e) {
		header("HTTP/1.1 500 Fatal Error");
	}
}

function save($post_id)
{
	$sql = "INSERT INTO saves (post_id, user_id)
          VALUES (:post_id, :user_id)";

	// Use 2 as the default id until we have session data
	$user_id = 2;

	$params =
		[
			":post_id" => $post_id,
			":user_id" => $user_id,
		];

	try {
		postDataFromSQL($sql, $params);
	} catch (Exception $e) {
		header("HTTP/1.1 500 Fatal Error");
	}
}

function report($id, $type)
{
	$sql = "INSERT INTO reports (reporter_id, id, type)
          VALUES (:reporter_id, :id, :type)";

	// Use 2 as the default id until we have session data
	$user_id = 2;

	$params =
		[
			":reporter_id" => $user_id,
			":id" => $id,
			":type" => $type,
		];

	try {
		postDataFromSQL($sql, $params);
	} catch (Exception $e) {
		header("HTTP/1.1 500 Fatal Error");
	}
}
