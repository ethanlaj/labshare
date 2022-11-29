<?PHP

header("Content-Type: application/json");

require_once(__DIR__ . "/../../database/notificationFunctions.php");

$notifications = get_notifications();

echo json_encode($notifications);
