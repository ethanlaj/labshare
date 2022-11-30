<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    <link rel="stylesheet" href="../stylesheets/profiles/createProfile.css" />
    <script src="../scripts/profiles/createProfile.js"></script>
    <title>Edit Pictures</title>
</head>

<body>
    <div id="navbar"></div>

    <form id="form" enctype="multipart/form-data" action="../api/profiles/editpictures.php" method="post">
        <div>
            <h1>Edit Pictures</h1>

            <div>
                <label for="profilepic" class="form-label">Please select a profile picture:</label>
                <!-- <input type="hidden" name="MAX_FILE_SIZE" value="30000" /> -->
                <input class="form-control" type="file" name="profilepic" id="profilepic" required capture="user" />
            </div>
            <div>
                <label for="banner" class="form-label">Please select a picture for the profile banner:</label>
                <!-- <input type="hidden" name="MAX_FILE_SIZE" value="30000" /> -->
                <input class="form-control" type="file" name="banner" id="banner" required capture="user" />
            </div>
            <div>
                <input class="btn btn-primary" type="submit" value="Submit" name="submit" id="submit" />
            </div>
        </div>
    </form>
    <div id="footer"></div>
</body>

</html>