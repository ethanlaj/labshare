<?PHP
ini_set("display_errors", 1);
error_reporting(E_ALL);

header("Content-Type: application/json");

require_once(__DIR__ . "/../../database/notificationFunctions.php");

$notifications = get_notifications();

echo json_encode($notifications);
