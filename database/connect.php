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

	// set the resulting array to associative
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$valuesArray = $stmt->fetchAll();
	return $valuesArray;
}


/**
 * @param string $sql - The sql to execute
 * @param array $params - Optional, The parameters for the SQL statement
 * @param boolean $get_inserted_id - Optional, if set to true, 
 * will return the last inserted row's id. 
 * 
 * @return string|void returns void if get_inserted_id is false, 
 * else returns the last inserted row's id;
 */
function postDataFromSQL($sql, $params = array(), $get_inserted_id = false)
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

	// Prevent HTML/XML injection 
	foreach ($params as $key => $value) {
		if (gettype($value) == "string")
			$params[$key] = htmlspecialchars($value, ENT_QUOTES);
	}

	$stmt = $conn->prepare($sql);
	$stmt->execute($params);

	if ($get_inserted_id)
		return $conn->lastInsertId();

	return;
}
