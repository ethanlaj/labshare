<?PHP
require_once(__DIR__ . "/../custom_session.php");


$logged_in_user = isset($_SESSION["user"])
	? $_SESSION["user"] : null;

if (!$logged_in_user) {
	header("Location: ../account/login.php");
	die();
}

require_once(__DIR__ . "/../global/validation.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Create Post</title>

	<!-- Bootstrap -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous" />

	<!--Montserrat Font-->
	<link rel="preconnect" href="https://fonts.googleapis.com" />
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,400;0,600;0,700;1,400&display=swap" rel="stylesheet" />

	<script src="../scripts/posting/postForms.js"></script>
	<link rel="stylesheet" href="../stylesheets/posting/postForms.css" />

	<!-- JQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

	<!--Global CSS and JS-->
	<link rel="stylesheet" href="../stylesheets/global/global.css" />
	<script src="../scripts/global/global.js"></script>

	<!--favicon-->
	<link rel="icon" type="image/x-icon" href="../images/LabShareLogo.png" />
</head>

<body>
	<div id="navbar"></div>

	<h1>Create Post</h1>
	<form id="postForm" action="../api/posting/createPost.php" method="post">
		<div class="inputContainer">
			<label class="form-label" for="title">Post Title</label>
			<input <?php echo convert_to_html("postTitle"); ?> id="title" name="title" class="form-control" type="text" />
		</div>
		<div class="inputContainer">
			<label class="form-label" for="zip">Zip Code</label>
			<input <?php echo convert_to_html("zip"); ?> class="form-control" id="zip" name="zip" type="text" />
		</div>
		<div class="inputContainer">
			<label class="form-label" for="content">Content</label>
			<textarea <?php echo convert_to_html("postContent"); ?> id="content" name="content" class="form-control" rows="15"></textarea>
		</div>

		<input id="submit" value="Create" class="btn btn-primary" type="submit" />
	</form>

	<footer id="footer"></footer>
</body>

</html>