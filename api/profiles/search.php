<?PHP
header("Content-Type: application/json");

require_once(__DIR__ . "/../../database/profileFunctions.php");

if (isset($_GET["search"]) && $_GET["search"]) {
	$users = search($_GET["search"]);

	echo json_encode($users);
} else {
	header("HTTP/1.1 400 Missing Parameters");
}
