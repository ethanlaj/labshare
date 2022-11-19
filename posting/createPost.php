<?PHP
session_start();

$logged_in_user = isset($_SESSION["user"])
	? $_SESSION["user"] : null;

if (!$logged_in_user) {
	header("Location: ../account/login.php");
	die();
}

require_once("../global/validation.php");
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

	<script type="module" src="./js/postForms.js"></script>
	<link rel="stylesheet" href="./css/postForms.css" />

	<!-- JQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

	<!--Global CSS and JS-->
	<link rel="stylesheet" href="../global/global.css" />
	<script src="../global/global.js"></script>

	<!--favicon-->
	<link rel="icon" type="image/x-icon" href="../global/LabShareLogo.png" />
</head>

<body>
	<div id="navbar"></div>

	<h1>Create Post</h1>
	<form id="postForm" action="./api/createPost.php" method="post">
		<div class="inputContainer">
			<label class="form-label" for="title">Post Title</label>
			<input <?php echo convertToHTML($patterns["postTitle"]); ?> id="title" name="title" class="form-control" type="text" />
		</div>
		<div class="inputContainer">
			<label class="form-label" for="zip">Zip Code</label>
			<input <?php echo convertToHTML($patterns["zip"]); ?> class="form-control" id="zip" name="zip" type="text" />
		</div>
		<div class="inputContainer">
			<label class="form-label" for="content">Content</label>
			<textarea <?php echo convertToHTML($patterns["postContent"]); ?> id="content" name="content" class="form-control" rows="15"></textarea>
		</div>

		<input id="submit" value="Create" class="btn btn-primary" type="submit" />
	</form>

	<footer id="footer"></footer>
</body>

</html>