<?PHP
header("Content-Type: application/json");

session_start();

$reload_required = false;

foreach ($_POST as $key => $value) {
	if (!isset($_SESSION[$key]))
		$reload_required = true;

	$_SESSION[$key] = $value;
}

echo json_encode($reload_required);
