<?PHP
ini_set("display_errors", 1);
error_reporting(E_ALL);

if (isset($_POST["username"]) && isset($_POST["password"])) {
    $current_user_id = isset($_SESSION["user"])
        ? $_SESSION["user"] : null;

    if ($current_user_id) {
        header("Location: ../../posting/posts.html");
    }

    require_once("../../database/accountFunctions.php");
    $user = get_user_login($_POST["username"]);

    $hash = $user["pwd"];
    $is_pwd_correct = password_verify($_POST["password"], $hash);

    if ($is_pwd_correct) {
        $_SESSION["user"] = $user["user_id"];
        echo "RIGHT";
    } else
        echo "WRONG";
} else {
    echo "WRONG PARAMS";
}

header("Location: ../../posting/posts.html");
