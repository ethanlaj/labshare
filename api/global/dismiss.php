<?PHP

if (isset($_POST["id"])) {
	require_once(__DIR__ . "/../../database/notificationFunctions.php");

	$noti_id = $_POST["id"];

	dismiss($noti_id);
} else {
	header("HTTP/1.1 400 Invalid parameters");
}
