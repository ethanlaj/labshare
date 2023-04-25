<?PHP
require_once(__DIR__ . "/../custom_session.php");

if (!isset($_SESSION["user"])) {
    header("Location: ../account/login.php");
    die();
}

require_once(__DIR__ . "/../database/accountFunctions.php");
require_once(__DIR__ . "/../global/validation.php");

$account = accountinfo();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Create Profile</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous" />

    <!--Montserrat Font-->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,400;0,600;0,700;1,400&display=swap" rel="stylesheet" />

    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!--Global CSS and JS-->
    <link rel="stylesheet" href="../stylesheets/global/global.css" />
    <script src="../scripts/global/global.js"></script>

    <link rel="stylesheet" href="../stylesheets/account/editaccount.css" />
    <script src="../scripts/account/editaccountinfo.js"></script>

    <!--favicon-->
    <link rel="icon" type="image/x-icon" href="../images/LabShareLogo.png" />
</head>

<body>
    <div id="navbar"></div>

    <form id="form" action="../api/account/checkCredentials.php" method="post">
        <div>
            <h1>Edit Account</h1>
        </div>

        <div class="inputContainer">
            <label for="userName" class="form-label marginless">New Username</label>
            <span> May only contain letters and numbers</span>
            <input <?PHP echo convert_to_html("username"); ?> type="text" value="<?PHP echo $account->username ?>" class="form-control" name="userName" id="userName" />
            <span id="useralert"></span>
        </div>
        <div class="inputContainer">
            <label for="oldpassword" class="form-label">Current Password</label>
            <input type="password" class="form-control" name="oldpassword" id="oldpassword" required />
            <span id="alert"></span>
        </div>
        <div class="inputContainer">
            <label for="password" class="form-label marginless">New Password</label>
            <span>Must contain at least 1 uppercase, 1 lowercase, 1 number, and 1 special character</span>
            <input <?PHP echo convert_to_html("new_password"); ?> type="password" class="form-control myform" name="password" id="password" />
        </div>
        <div class="inputContainer">
            <label for="firstName" class="form-label">First Name</label>
            <input <?PHP echo convert_to_html("firstName"); ?> type="text" value="<?PHP echo $account->firstName ?>" class=" form-control myform" name="firstName" id="firstName" />
        </div>
        <div class="inputContainer">
            <label for="lastName" class="form-label">Last Name</label>
            <input <?PHP echo convert_to_html("lastName"); ?> type="text" value="<?PHP echo $account->lastName ?>" class=" form-control myform" name="lastName" id="lastName" />
        </div>
        <div class="inputContainer">
            <label for="email" class="form-label">Change Primary Email</label>
            <input <?PHP echo convert_to_html("email"); ?> type="text" value="<?PHP echo $account->email ?>" class="form-control myform" name="email" id="email" />
        </div>
        <div class="inputContainer">
            <label for="phone" class="form-label">Change Phone Number</label>
            <input <?PHP echo convert_to_html("phone"); ?> type="text" value="<?PHP echo $account->phoneNumber ?>" class="form-control myform" name="phone" id="phone" />
        </div>
        <div class="inputContainer">
            <label for="birthday" class="form-label">Birthday</label>
            <input <?PHP echo convert_to_html("birthday"); ?> type="date" value="<?PHP echo $account->birthday ?>" class=" form-control myform" name="birthday" id="birthday" />
        </div>

        <div class="inputContainer">
            <input class="btn btn-primary" type="submit" value="Submit" id="submit" />
        </div>
    </form>

    <div id="footer"></div>
</body>

</html>