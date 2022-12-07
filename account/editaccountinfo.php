<?PHP
session_start();
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

    <link rel="stylesheet" href="../stylesheets/account/account.css" />
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

        <article>
            <label for="userName" class="form-label">New Username</label>
            <input <?PHP echo convertToHTML($patterns["username"]); ?> type="text" value="<?PHP echo $account->username ?>" class="form-control" name="userName" id="userName" minlength="2" maxlength="45" required />
            <span id="useralert"></span>
        </article>
        <article>
            <label for="oldpassword" class="form-label">Current Password</label>
            <input type="text" class="form-control" name="oldpassword" id="oldpassword" minlength="2" maxlength="45" required />
            <span id="alert"></span>
        </article>
        <article>
            <label for="password" class="form-label">New Password</label>
            <input <?PHP echo convertToHTML($patterns["new_password"]); ?> type="text" class="form-control" name="password" id="password" />
        </article>
        <article>
            <label for="firstName" class="form-label">First Name</label>
            <input <?PHP echo convertToHTML($patterns["firstName"]); ?> type="text" value="<?PHP echo $account->firstName ?>" class=" form-control" name="firstName" id="firstName" />
        </article>
        <article>
            <label for="lastName" class="form-label">Last Name</label>
            <input <?PHP echo convertToHTML($patterns["lastName"]); ?> type="text" value="<?PHP echo $account->lastName ?>" class=" form-control" name="lastName" id="lastName" />
        </article>
        <article>
            <label for="email" class="form-label">Change Primary Email</label>
            <input <?PHP echo convertToHTML($patterns["email"]); ?> type="text" value="<?PHP echo $account->email ?>" class="form-control" name="email" id="email" />
        </article>
        <article>
            <label for="phone" class="form-label">Change Phone Number</label>
            <input <?PHP echo convertToHTML($patterns["phone"]); ?> type="text" value="<?PHP echo $account->phoneNumber ?>" class="form-control" name="phone" id="phone" />
        </article>
        <article>
            <label for="birthday" class="form-label">Birthday</label>
            <input <?PHP echo convertToHTML($patterns["birthday"]); ?> type="date" value="<?PHP echo $account->birthday ?>" class=" form-control" name="birthday" id="birthday" />
        </article>

        <article>
            <input class="btn btn-primary" type="submit" value="Submit" id="submit" />
        </article>
    </form>

    <div id="footer"></div>
</body>

</html>