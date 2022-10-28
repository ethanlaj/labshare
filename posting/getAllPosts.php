<?PHP
	header("Content-Type: application/json");

	require_once("../database/postFunctions.php");
	require_once("../database/userFunctions.php");

	$posts = getPosts();

	echo json_encode($posts);
?>