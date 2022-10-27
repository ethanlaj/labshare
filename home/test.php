<?PHP
 // connect to our database

 
$host = getenv("SP_HOST_NAME");
$database = getenv("SP_SCHEMA");
$username = getenv("SP_USERNAME");
$password = getenv("SP_PASSWORD");
$dns = "mysql:host=$host;dbname=$database;charset=UTF8";
$dbconnection = new PDO($dns, $username, $password);



 // make sql
$sql = "SELECT username,user_id FROM users;";
$statement = $dbconnection->prepare($sql);

// get list
$statement->execute();
$users = $statement->fetchAll();
// loop over list and display the names
foreach($users as $user) {
 echo "<p>";
 echo $user["username"] . " " . $user["user_id"];
 echo "</p>";
 }




?>