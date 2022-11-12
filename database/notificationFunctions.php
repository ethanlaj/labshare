<?PHP

// Include connection
require_once "connect.php";
require_once "classes.php";

ini_set("display_errors", 1);
error_reporting(E_ALL);

function get_notifications(): array
{
	$sql = "SELECT notification_id,notification_date,type,post_id,count,title,poster_id,poster,posterEmail,posterPhone,applicant_id,applicant,applicantEmail,applicantPhone FROM advanced_notification WHERE inactive=0";

	$params = array();

	$notifications = getDataFromSQL($sql, $params);

	$notifications_array = array();

	foreach ($notifications as $notification)
		array_push($notifications_array, new Notification($notification));

	return $notifications_array;
}
