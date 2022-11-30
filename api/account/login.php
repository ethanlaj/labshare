<?PHP
header("Content-type: application/json");

$output = array();

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
        $output["user_verify"] = true;
    } else
        $output["user_verify"] = false;

    $hash = $user["pwd"];
    $is_pwd_correct = password_verify($_POST["password"], $hash);

    if ($is_pwd_correct) {
        $_SESSION["user"] = $user["user_id"];
        $output["password_verify"] = true;
    } else {
        $output["password_verify"] = false;
    }
} else {
    echo "WRONG PARAMS";
}

echo json_encode($output);
