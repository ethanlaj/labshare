<?PHP
$post = null;

ini_set("display_errors", 1);
error_reporting(E_ALL);

if (isset($_GET["id"])) {
	require_once("../database/postFunctions.php");

	$post = getPost($_GET["id"]);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Edit Post</title>

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

	<?PHP if ($post) { ?>

		<h1>Edit Post</h1>
		<form id="postForm" action="./api/editPost.php" method="post">
			<input type="hidden" name="post_id" value="<?PHP echo $post->post_id ?>">
			<div class="inputContainer">
				<label class="form-label" for="title">Post Title</label>
				<input required minlength="10" maxlength="50" id="title" name="title" class="form-control" type="text" value="<?PHP echo $post->title ?>" />
			</div>
			<div class="inputContainer">
				<label class="form-label" for="zip">Zip Code</label>
				<input class="form-control" id="zip" name="zip" maxlength="10" type="text" pattern="[0-9]*" value="<?PHP echo $post->zip ?>" />
			</div>
			<div class="inputContainer">
				<label class="form-label" for="content">Content</label>
				<textarea required minlength="50" maxlength="2000" id="content" name="content" class="form-control" rows="15"><?PHP echo $post->content ?></textarea>
			</div>

			<input id="submit" value="Edit" class="btn btn-primary" type="submit" />
		</form>

	<?PHP } else { ?>
		<p>This post has been deleted or does not exist.</p>
	<?PHP } ?>

	<footer id="footer"></footer>
</body>

</html>