<?PHP
	if (isset($_GET["id"])) {
		require_once("../database/postFunctions.php");
		require_once("../database/userFunctions.php");

		$post = getPost($_GET["id"]);
		
		return $post;
	} else {
		header("HTTP/1.1 400 Invalid parameter!");

		return null;
	}
?>