<?PHP

// Include connection
require_once "connect.php";
require_once "classes.php";



function get_notification($noti_id)
{
	if (!isset($_SESSION["user"]))
		return null;

	$user_id = $_SESSION["user"];

	$sql = "SELECT post_id,applicant_id 
	FROM advanced_notification
	WHERE inactive=0
	AND notification_id=:noti_id
	AND (
		(type IN ('NEW_APP', 'POST_SAVED') AND poster_id=:user_id)
		OR (type IN ('APP_ACCEPT', 'APP_DECLINE') AND applicant_id=:user_id)
		)";

	$params =
		[
			":noti_id" => $noti_id,
			":user_id" => $user_id,
		];

	try {
		$resp = getDataFromSQL($sql, $params)[0];

		return new Notification($resp);
	} catch (Exception $e) {
		header("HTTP/1.1 500 Fatal Error");
	}
}

function get_notifications(): array
{
	if (!isset($_SESSION["user"]))
		return header("HTTP/1.1 401 Unauthorized");

	$user_id = $_SESSION["user"];

	$sql = "SELECT notification_id,notification_date,type,post_id,
	count,title,poster_id,poster,posterEmail,posterPhone,
	applicant_id,applicant,applicantEmail,applicantPhone 
	FROM advanced_notification 
	WHERE inactive=0 
	AND (
		(type IN ('NEW_APP', 'POST_SAVED') AND poster_id=:user_id)
		OR (type IN ('APP_ACCEPT', 'APP_DECLINE') AND applicant_id=:user_id)
		)
	ORDER BY notification_date DESC";

	$params = [":user_id" => $user_id];

	$notifications = getDataFromSQL($sql, $params);

	$notifications_array = array();

	foreach ($notifications as $notification)
		array_push($notifications_array, new Notification($notification));

	return $notifications_array;
}

$dismiss_sql = "UPDATE notifications 
		SET inactive=1
		WHERE notification_id=:noti_id";

function update_application($noti_id, $accept = false)
{
	global $dismiss_sql;

	$noti = get_notification($noti_id);

	if (!$noti)
		return header("HTTP/1.1 404 Not Found");

	$sql = "UPDATE applications 
		SET status=:status
		WHERE user_id=:applicant_id AND post_id=:post_id;" . $dismiss_sql;

	$params = [
		":post_id" => $noti->post_id,
		":applicant_id" => $noti->applicant_id,
		":status" => $accept ? "ACCEPT" : "DECLINE",
		":noti_id" => $noti_id
	];

	try {
		postDataFromSQL($sql, $params);
	} catch (Exception $e) {
		header("HTTP/1.1 500 Fatal Error");
	}
}

function dismiss($noti_id)
{
	global $dismiss_sql;

	$noti = get_notification($noti_id);

	if (!$noti)
		return header("HTTP/1.1 404 Not Found");

	$params = [
		":noti_id" => $noti_id
	];

	try {
		postDataFromSQL($dismiss_sql, $params);
	} catch (Exception $e) {
		header("HTTP/1.1 500 Fatal Error");
	}
}
