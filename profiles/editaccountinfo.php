<?PHP
$account = null;

ini_set("display_errors", 1);
error_reporting(E_ALL);

require_once("../database/accountFunctions.php");

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
    <link rel="stylesheet" href="../global/global.css" />
    <script src="../global/global.js"></script>

    <link rel="stylesheet" href="./css/createprofile.css" />
    <script src="./js/createprofile.js"></script>

    <!--favicon-->
    <link rel="icon" type="image/x-icon" href="../global/LabShareLogo.png" />
</head>

<body>
    <div id="navbar"></div>

    <form id="form" action="api/editaccountinfo.php" method="post">
        <div>
            <h1>Edit Account</h1>
        </div>

        <div>
            <p>Current Username: <?PHP echo $account->username ?></p>
            <label for="userName" class="form-label">New Username</label>
            <input type="text" class="form-control" name="userName" id="userName" minlength="2" maxlength="45" required />
        </div>
        <div>
            <label for="password" class="form-label">New password</label>
            <input type="text" class="form-control" name="password" id="password" minlength="2" maxlength="45" required />
        </div>
        <div>
            <label for="email" class="form-label">Change primary email</label>
            <input type="text" value="<?PHP echo $account->email ?>" class="form-control" name="email" id="email" minlength="2" maxlength="45" required />
        </div>
        <div>
            <label for="phone" class="form-label">Change phone number</label>
            <input type="text" value="<?PHP echo $account->phoneNumber ?>" class="form-control" name="phone" id="phone" minlength="2" maxlength="45" required />
        </div>

        <div>
            <input class="btn btn-primary" type="submit" value="Submit" id="submit" />
        </div>
    </form>

    <div id="footer"></div>
</body>

</html>