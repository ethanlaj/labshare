<?PHP
ini_set("display_errors", 1);
error_reporting(E_ALL);

session_start();

if (!array_key_exists("time", $_SESSION)) {
	$_SESSION["time"] = time();
}

echo $_SESSION["time"];
