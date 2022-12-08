<?PHP
// Create DB connection
$host = getenv("SP_HOST_NAME");
$database = getenv("SP_SCHEMA");
$db_username = getenv("SP_USERNAME");
$db_password = getenv("SP_PASSWORD");
$port = getenv("SP_PORT");

$dns = "mysql:host=$host;dbname=$database;charset=UTF8;port=$port";

/**
 * @param string $sql The sql to execute
 * @param array $params Optional, The parameters for the SQL statement
 * @param array $safe_keys Optional, the array of keys not to prevent HTML/XML injection for
 * 
 * @return array Returns the data from the database after calling the SQL.
 */
function getDataFromSQL($sql, $params = null, $safe_keys = array())
{
	global $dns, $db_username, $db_password;
	try {
		$conn = new PDO($dns, $db_username, $db_password);
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
	$rows = $stmt->fetchAll();


	// Prevent HTML/XML injection
	$output = array();
	foreach ($rows as $row) {
		foreach ($row as $key => $value) {
			if (gettype($value) == "string" && array_search($key, $safe_keys) === false)
				$row[$key] = htmlspecialchars($value, ENT_QUOTES);
		}

		array_push($output, $row);
	}

	return $output;
}


/**
 * @param string $sql The sql to execute
 * @param array $params Optional, The parameters for the SQL statement
 * @param boolean $get_inserted_id Optional, if set to true, 
 * will return the last inserted row's id. 
 * 
 * @return string|void returns void if get_inserted_id is false, 
 * else returns the last inserted row's id;
 */
function postDataFromSQL($sql, $params = array(), $get_inserted_id = false)
{
	global $dns, $db_username, $db_password;
	try {
		$conn = new PDO($dns, $db_username, $db_password);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//echo "Connected successfully";
	} catch (PDOException $e) {
		echo "Connection failed: " . $e->getMessage();
	}

	$stmt = $conn->prepare($sql);
	$stmt->execute($params);

	if ($get_inserted_id)
		return $conn->lastInsertId();

	return;
}
