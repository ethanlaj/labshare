<?PHP
ini_set("display_errors", 1);
error_reporting(E_ALL);

$VALID_TYPES = array(1, 2);

if (isset($_POST["id"]) && isset($_POST["type"])) {
	require_once("../../database/postFunctions.php");

	$post_id = $_POST["id"];
	$type = (int) $_POST["type"];

	if (!in_array($type, $VALID_TYPES))
		return header("HTTP/1.1 400 Invalid type parameter");

	report($post_id, $type);
} else {
	header("HTTP/1.1 400 Invalid parameters");
}
