<?PHP
ini_set("display_errors", 1);
error_reporting(E_ALL);

if (isset($_POST["post_id"])) {
	require_once("../../database/postFunctions.php");

	$post_id = $_POST["post_id"];

	apply($post_id);
} else {
	header("HTTP/1.1 400 Invalid parameters");
}
