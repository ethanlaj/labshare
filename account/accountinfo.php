<?PHP
require_once(__DIR__ . "/../custom_session.php");
require_once(__DIR__ . "/../database/accountFunctions.php");

$user_id = null;
if (isset($_SESSION["user"])) {
    $user_id = $_SESSION["user"];
}
$account = accountinfo();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My Account</title>

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
    <script src="../scripts/account/accountinfo.js"></script>

    <!--favicon-->
    <link rel="icon" type="image/x-icon" href="../images/LabShareLogo.png" />
</head>

<body>
    <div id="navbar"></div>
    <div id="box">
        <div>
            <h1>Account Info</h1>
        </div>
        <div>
            <h6><strong>Username:</strong> <?PHP echo $account->username ?> </h6>
        </div>
        <div>
            <h6><strong>First Name:</strong> <?PHP echo $account->firstName ?></h6>
        </div>
        <div>
            <h6><strong>Last Name:</strong> <?PHP echo $account->lastName ?></h6>
        </div>
        <div>
            <h6><strong>Email Address:</strong> <?PHP echo $account->email ?></h6>
        </div>
        <div>
            <h6><strong>Phone Number:</strong> <?PHP echo $account->phoneNumber ?></h6>
        </div>
        <div>
            <h6><strong>Birthday:</strong> <?PHP echo $account->birthday ?></h6>
        </div>
        <div>
            <button class="btn btn-primary" id="edit">Edit Account</button>
        </div>
    </div>

    <div id="footer"></div>
</body>