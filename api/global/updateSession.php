<?PHP
require_once(__DIR__ . "/../../custom_session.php");

header("Content-Type: application/json");


$reload_required = false;
$logged_in = false;

if (array_key_exists('timezone', $_POST)) {
	if (!isset($_SESSION['timezone']))
		$reload_required = true;

	$_SESSION['timezone'] = $_POST['timezone'];
}

if (isset($_SESSION["user"]))
	$logged_in = true;

$arr = array("reload" => $reload_required, "logged_in" => $logged_in);

echo json_encode($arr);
