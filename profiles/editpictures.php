<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pictures</title>
</head>

<body>
    <form id="form" action="" method="post">
        <div>
            <h1>Edit Pictures</h1>

            <div>
                <label for="profilepic" class="form-label">Please select a profile picture:</label>

                <input class="form-control" enctype="multipart/form-data" type="file" name="profilepic" id="profilePic" required capture="user" />
            </div>
            <div>
                <label for="banner" class="form-label">Please select a picture for the profile banner:</label>

                <input class="form-control" enctype="multipart/form-data" type="file" name="banner" id="banner" required capture="user" />
            </div>
            <div>
                <input class="btn btn-primary" type="submit" value="Submit" id="submit" />
            </div>
    </form>

</body>

</html>