<?PHP
header("Content-type: application/json");

$output = array();
$user_success = false;
$password_success = false;

if (isset($_POST["username"]) && isset($_POST["password"])) {
    $current_user_id = isset($_SESSION["user"])
        ? $_SESSION["user"] : null;

    if ($current_user_id) {
        header("Location: ../../posting/posts.html");
    }

    require_once(__DIR__ . "/../../database/accountFunctions.php");
    $user = null;
    $user = get_user_login($_POST["username"]);
    if ($user) {
        $user_success = true;
    } else
        $user_success = false;

    $hash = $user["pwd"];
    $is_pwd_correct = password_verify($_POST["password"], $hash);

    if ($is_pwd_correct) {
        $_SESSION["user"] = $user["user_id"];
        $password_success = true;
    } else {
        $password_success = false;
    }
} else {
    // echo "WRONG PARAMS";
}
if ($user_success && $password_success) {
    $output["loginSuccess"] = true;
}
echo json_encode($output);
