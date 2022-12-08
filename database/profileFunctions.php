<?PHP
// Include connection
require_once "connect.php";
require_once "classes.php";

function search($searchQuery)
{
    $sql = "SELECT user_id, profilepic, username, firstName, lastName
            FROM users
            WHERE inactive = 0 
            AND (username LIKE :q
            OR firstName LIKE :q
            OR lastName LIKE :q
            OR CONCAT(firstName, ' ', lastName) LIKE :q)";

    $params =
        [
            ":q" => '%' . $searchQuery . '%',
        ];

    try {
        $users = getDataFromSQL($sql, $params);

        $user_array = array();

        foreach ($users as $user)
            array_push($user_array, new User($user));

        return $user_array;
    } catch (Exception $e) {
        header("HTTP/1.1 500 Fatal Error");
    }
}
