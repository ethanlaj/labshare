<?PHP
session_start();

// Include connection
require_once "connect.php";
require_once "classes.php";
require_once "userFunctions.php";

ini_set("display_errors", 1);
error_reporting(E_ALL);

function convertToLocal($datetime)
{
	$timestamp = strtotime($datetime . ' UTC');

	$date = new DateTime("@" . $timestamp);

	if (isset($_SESSION["timezone"])) {
		$date->setTimezone(new DateTimeZone($_SESSION["timezone"]));
	}

	return $date->format('m/d/Y \a\t g:ia');
}

function get_post_author($post_id)
{
	$sql = "SELECT author_id FROM posts WHERE post_id=:post_id";
	$params = [":post_id" => $post_id];

	try {
		return getDataFromSQL($sql, $params)[0]["author_id"];
	} catch (Exception $e) {
		header("HTTP/1.1 500 Fatal Error");
	}
}

function get_comment_author($comment_id)
{
	$sql = "SELECT author_id FROM comments WHERE comment_id=:comment_id";
	$params = [":comment_id" => $comment_id];

	try {
		return getDataFromSQL($sql, $params)[0]["author_id"];
	} catch (Exception $e) {
		header("HTTP/1.1 500 Fatal Error");
	}
}

function getPost($post_id, $includeExtraData = false)
{
	$sql = "SELECT post_id,creationDate,title,content,fullName,username,profilepic,author_id,zip FROM post_with_username WHERE inactive=0 AND post_id=:id";
	$params = [":id" => $post_id];

	$posts = getDataFromSQL($sql, $params);

	if (count($posts) == 0)
		return null;

	$post = $posts[0];
	if ($post) {
		return new Post($post, $includeExtraData);
	} else return null;
}

function getLocationData($zip)
{
	try {
		$response = file_get_contents("https://api.zippopotam.us/us/$zip");
		$response = json_decode($response);

		return $response->places[0];
	} catch (Exception $e) {
		return null;
	}
}

function createPost($title, $content, $zip)
{
	if (!isset($_SESSION["user"]))
		return header("HTTP/1.1 401 Unauthorized");

	$author_id = $_SESSION["user"];

	// Add latitude/longitude to database
	$location_data = null;
	if ($zip) {
		$location_data = getLocationData($zip);

		if ($location_data) {
			$sql = "INSERT INTO posts (author_id, title, content, zip, lat, lon)
				VALUES (:author_id, :title, :content, :zip, :lat, :lon)";

			$params = [
				":author_id" => $author_id,
				":title" => $title,
				":content" => $content,
				":zip" => $zip,
				":lat" => $location_data->latitude,
				":lon" => $location_data->longitude,
			];
		}
	}
	if (!$zip || !$location_data) {
		$sql = "INSERT INTO posts (author_id, title, content, zip)
				VALUES (:author_id, :title, :content, :zip)";

		$params = [
			":author_id" => $author_id,
			":title" => $title,
			":content" => $content,
			":zip" => $zip
		];
	}

	try {
		return postDataFromSQL($sql, $params, true);
	} catch (Exception $e) {
		header("HTTP/1.1 500 Fatal Error");
	}
}

function editPost($post_id, $title, $content, $zip)
{
	$actual_author = get_post_author($post_id);

	if (!isset($_SESSION["user"]) || $_SESSION["user"] != $actual_author)
		return header("HTTP/1.1 401 Unauthorized");

	$author_id = $_SESSION["user"];

	$sql = "UPDATE posts 
			SET title=:title, content=:content, zip=:zip, lat=:lat, lon=:lon
			WHERE post_id=:post_id AND author_id=:author_id";

	$params = [
		":post_id" => $post_id,
		":author_id" => $author_id,
		":title" => $title,
		":content" => $content,
		":zip" => $zip,
	];

	// Update latitude/longitude in database
	$location_data = null;
	if ($zip) {
		$location_data = getLocationData($zip);

		if ($location_data) {
			$params[":lat"] = $location_data->latitude;
			$params[":lon"] = $location_data->longitude;
		}
	}
	if (!$zip || !$location_data) {
		$params[":lat"] = null;
		$params[":lon"] = null;
	}

	try {
		postDataFromSQL($sql, $params);
	} catch (Exception $e) {
		header("HTTP/1.1 500 Fatal Error");
	}
}

function deletePost($post_id)
{
	$actual_author = get_post_author($post_id);

	if (!isset($_SESSION["user"]) || $_SESSION["user"] != $actual_author)
		return header("HTTP/1.1 401 Unauthorized");

	$author_id = $_SESSION["user"];

	$sql = "UPDATE posts 
	SET inactive=1
	WHERE post_id=:post_id AND author_id=:author_id";

	$params = [
		":post_id" => $post_id,
		":author_id" => $author_id,
	];

	try {
		postDataFromSQL($sql, $params);
	} catch (Exception $e) {
		header("HTTP/1.1 500 Fatal Error");
	}
}

function getPosts($type, $search): array
{
	$sql = "SELECT post_id,creationDate,title,content,username,fullName,profilepic,author_id,zip,lat,lon FROM post_with_username WHERE inactive=0";

	$params = array();

	if ($type == "your") {
		$sql = $sql . " AND author_id=:user_id";
	} else if ($type == "saved")
		$sql = $sql . " AND post_id IN (SELECT post_id FROM saves WHERE user_id=:user_id)";
	else $type = null;

	// If a search parameter is passed, find posts 
	// where the title or content match the search query 
	if ($search && strlen(trim($search)) > 0) {
		$sql = $sql . " AND (title LIKE :search OR content LIKE :search)";

		$params[":search"] = '%' . $search . '%';
	}

	$sql = $sql . " ORDER BY creationDate DESC";

	if ($type) {
		if (isset($_SESSION["user"]))
			$params[":user_id"] = $_SESSION["user"];
		else
			return header("HTTP/1.1 401 Unauthorized");
	}

	$posts = getDataFromSQL($sql, $params);

	$post_array = array();

	foreach ($posts as $post)
		array_push($post_array, new Post($post));

	return $post_array;
}

function getCommentsForPost($post_id): array
{
	$sql = "SELECT comment_id,author_id,creationDate,parent_id,content,username,fullName,profilepic FROM comment_with_username WHERE inactive=0 AND post_id=:id AND parent_id IS NULL";
	$params = [":id" => $post_id];

	$comments = getDataFromSQL($sql, $params);

	$comment_array = array();

	foreach ($comments as $comment)
		array_push($comment_array, new Comment($comment, true));

	return $comment_array;
}

function getRepliesToComment($comment_id): array
{
	$sql = "SELECT comment_id,author_id,creationDate,parent_id,content,username,fullName,profilepic FROM comment_with_username WHERE inactive=0 AND parent_id=:id";
	$params = [":id" => $comment_id];

	$comments = getDataFromSQL($sql, $params);

	$comment_array = array();

	foreach ($comments as $comment)
		array_push($comment_array, new Comment($comment,));

	return $comment_array;
}

function addComment($post_id, $content, $parent_id = null)
{
	if (!isset($_SESSION["user"]))
		return header("HTTP/1.1 401 Unauthorized");

	$author_id = $_SESSION["user"];

	$sql = "INSERT INTO comments (post_id, author_id, content, parent_id)
          VALUES (:post_id, :author_id, :content, :parent_id)";

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

function editComment($comment_id, $content)
{
	$actual_author = get_comment_author($comment_id);

	if (!isset($_SESSION["user"]) || $_SESSION["user"] != $actual_author)
		return header("HTTP/1.1 401 Unauthorized");

	$sql = "UPDATE comments 
			SET content=:content
			WHERE comment_id=:comment_id AND author_id=:author_id";

	$params = [
		":comment_id" => $comment_id,
		":author_id" => $actual_author,
		":content" => $content
	];

	try {
		postDataFromSQL($sql, $params);
	} catch (Exception $e) {
		header("HTTP/1.1 500 Fatal Error");
	}
}

function deleteComment($comment_id)
{
	$actual_author = get_comment_author($comment_id);

	if (!isset($_SESSION["user"]) || $_SESSION["user"] != $actual_author)
		return header("HTTP/1.1 401 Unauthorized");

	$sql = "UPDATE comments 
	SET inactive=1
	WHERE (comment_id=:comment_id 
	AND author_id=:author_id)
	OR parent_id=:comment_id";

	$params = [
		":comment_id" => $comment_id,
		":author_id" => $actual_author
	];

	try {
		postDataFromSQL($sql, $params);
	} catch (Exception $e) {
		header("HTTP/1.1 500 Fatal Error");
	}
}

function applicationExists($post_id)
{
	if (!isset($_SESSION["user"]))
		return header("HTTP/1.1 401 Unauthorized");

	$user_id = $_SESSION["user"];

	$sql = "SELECT COUNT(post_id) as \"count\" FROM applications
          WHERE post_id=:post_id AND user_id=:user_id";

	$params =
		[
			":post_id" => $post_id,
			":user_id" => $user_id,
		];

	try {
		$resp = getDataFromSQL($sql, $params)[0];

		return $resp["count"] > 0;
	} catch (Exception $e) {
		header("HTTP/1.1 500 Fatal Error");
	}
}

function apply($post_id)
{
	$actual_author = get_post_author($post_id);

	if (!isset($_SESSION["user"]) || $_SESSION["user"] == $actual_author)
		return header("HTTP/1.1 401 Unauthorized");

	$user_id = $_SESSION["user"];

	if (applicationExists($post_id)) {
		return header("HTTP/1.1 403 Already Exists");
	}

	$sql = "INSERT INTO applications (post_id, user_id)
          VALUES (:post_id, :user_id)";

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

function saveExists($post_id)
{
	if (!isset($_SESSION["user"]))
		return header("HTTP/1.1 401 Unauthorized");

	$user_id = $_SESSION["user"];

	$sql = "SELECT COUNT(post_id) as \"count\" FROM saves
          WHERE post_id=:post_id AND user_id=:user_id";

	$params =
		[
			":post_id" => $post_id,
			":user_id" => $user_id,
		];

	try {
		$resp = getDataFromSQL($sql, $params)[0];

		return $resp["count"] > 0;
	} catch (Exception $e) {
		header("HTTP/1.1 500 Fatal Error");
	}
}

function save($post_id)
{
	$actual_author = get_post_author($post_id);

	if (!isset($_SESSION["user"]) || $_SESSION["user"] == $actual_author)
		return header("HTTP/1.1 401 Unauthorized");

	$user_id = $_SESSION["user"];

	if (saveExists($post_id)) {
		return header("HTTP/1.1 403 Already Exists");
	}

	$sql = "INSERT INTO saves (post_id, user_id)
          VALUES (:post_id, :user_id)";

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

function unsave($post_id)
{
	$actual_author = get_post_author($post_id);

	if (!isset($_SESSION["user"]) || $_SESSION["user"] == $actual_author)
		return header("HTTP/1.1 401 Unauthorized");

	$user_id = $_SESSION["user"];

	if (!saveExists($post_id)) {
		return header("HTTP/1.1 403 Does Not Exist");
	}

	$sql = "DELETE FROM saves
          WHERE post_id=:post_id AND user_id=:user_id";

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

function reportExists($id, $type)
{
	if (!isset($_SESSION["user"]))
		return header("HTTP/1.1 401 Unauthorized");

	$user_id = $_SESSION["user"];

	$sql = "SELECT COUNT(id) as \"count\" FROM reports
          WHERE id=:id AND type=:type AND reporter_id=:user_id";

	$params =
		[
			":id" => $id,
			":type" => $type,
			":user_id" => $user_id,
		];

	try {
		$resp = getDataFromSQL($sql, $params)[0];

		return $resp["count"] > 0;
	} catch (Exception $e) {
		header("HTTP/1.1 500 Fatal Error");
	}
}

function report($id, $type)
{
	$actual_author = $type == 1
		? get_post_author($id) : get_comment_author($id);

	if (!isset($_SESSION["user"]) || $_SESSION["user"] == $actual_author)
		return header("HTTP/1.1 401 Unauthorized");

	$user_id = $_SESSION["user"];

	if (reportExists($id, $type)) {
		return header("HTTP/1.1 403 Already Exists");
	}

	$sql = "INSERT INTO reports (reporter_id, id, type)
          VALUES (:reporter_id, :id, :type)";

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
