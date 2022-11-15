<?PHP
header("Content-Type: application/json");

session_start();

$reload_required = false;
$logged_in = false;

foreach ($_POST as $key => $value) {
	if (!isset($_SESSION[$key]))
		$reload_required = true;

	$_SESSION[$key] = $value;
}

if (isset($_SESSION["user"]))
	$logged_in = true;

$arr = array("reload" => $reload_required, "logged_in" => $logged_in);

echo json_encode($arr);
