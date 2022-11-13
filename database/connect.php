<?PHP
// Create DB connection
$host = getenv("SP_HOST_NAME");
$database = getenv("SP_SCHEMA");
$username = getenv("SP_USERNAME");
$password = getenv("SP_PASSWORD");
$dns = "mysql:host=$host;dbname=$database;charset=UTF8;port=25060";
$dbconnection = new PDO($dns, $username, $password);

function getDataFromSQL($sql, $params = null)
{
	global $dns, $username, $password;
	try {
		$conn = new PDO($dns, $username, $password);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//echo "Connected successfully";
	} catch (PDOException $e) {
		echo "Connection failed: " . $e->getMessage();
	}

	$stmt = $conn->prepare($sql);
	$stmt->execute($params);
	$stmt->execute();

	// set the resulting array to associative
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$valuesArray = $stmt->fetchAll();
	return $valuesArray;
}

function postDataFromSQL($sql, $params = null)
{
	global $dns, $username, $password;
	try {
		$conn = new PDO($dns, $username, $password);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//echo "Connected successfully";
	} catch (PDOException $e) {
		echo "Connection failed: " . $e->getMessage();
	}

	$stmt = $conn->prepare($sql);
	$stmt->execute($params);

	return;
}
