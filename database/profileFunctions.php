<?PHP
// Include connection
require_once "connect.php";
require_once "classes.php";

function getUsers($searchQuery)
{
    $sql = "SELECT user_id, profilepic, username, firstName, lastName
            FROM users
            WHERE username LIKE :q
            OR firstName LIKE :q
            OR lastName LIKE :q";

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

function createProfile(
    $user_id,
    $quals_degrees = null,
    $areaOfStudy = null,
    $yearsOfStudy = null,
    $secondaryAreaOfStudy = null,
    $about = null,
    $achievements_interests = null,
    $fullName = null,
    $age = null,
    $profilepic = null,
    $banner = null
) {
    $sql = "INSERT INTO profiles (user_id,
    quals_degrees,
    areaOfStudy,
    yearsOfStudy,
    secondaryAreaOfStudy,
    about,
    achievements_interests,
    fullName,
    age,
    profilepic,
    banner)
          VALUES (:user_id,
		:quals_degrees,
		:areaOfStudy,
		:yearsOfStudy,
		:secondaryAreaOfStudy,
		:about,
		:achievements_interests,
        :fullName,
        :age,
        :profilepic,
        :banner)";


    $params =
        [
            ":user_id" => $user_id,
            ":quals_degrees" => $quals_degrees,
            ":areaOfStudy" => $areaOfStudy,
            ":yearsOfStudy" => $yearsOfStudy,
            ":secondaryAreaOfStudy" => $secondaryAreaOfStudy,
            ":about" => $about,
            ":achievements_interests" => $achievements_interests,
            ":fullName" => $fullName,
            ":age" => $age,
            ":profilepic" => $profilepic,
            ":banner" => $banner

        ];

    try {
        postDataFromSQL($sql, $params);
    } catch (Exception $e) {
        header("HTTP/1.1 500 Fatal Error");
    }
}


function fetchProfile()
{
    $sql = "SELECT * FROM profiles;";

    $prof = getDataFromSQL($sql)[0];


    return new Profile(4, $prof["quals_degrees"], $prof["areaOfStudy"], $prof["yearsOfStudy"], $prof["secondaryAreaOfStudy"], $prof["about"], $prof["achievements_interests"], $prof["fullName"], $prof["age"], $prof["profilepic"], $prof["banner"]);
}
