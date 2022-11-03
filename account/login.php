<?PHP
session_start();

$user_id = null;
if (isset($_SESSION["user"])) {
	$user_id = $_SESSION["user"];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Login</title>

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

	<link rel="stylesheet" href="./css/login.css" />
	<script src="./js/login.js"></script>

	<!--favicon-->
	<link rel="icon" type="image/x-icon" href="../global/LabShareLogo.png" />
</head>

<body class="container" id="flexcontainer">
	<?PHP if (!$user_id) { ?>
		<main class="row justify-content-center align-items-center my-row" id="row">
			<section class="col-med-4 col-sm-12 my-col" id="leftside">
				<form action="./api/login.php" method="post">
					<article>
						<h1>Login</h1>
					</article>
					<article>
						<label for="username" class="form-label">Username or Email Address</label>
						<input type="text" class="form-control" name="username" id="username" required />
					</article>
					<article>
						<label for="password" class="form-label">Password</label>
						<input type="password" class="form-control" name="password" id="password" required />
					</article>
					<article>
						<input class="btn btn-primary" type="submit" value="Submit" id="submit" />
					</article>
				</form>
			</section>

			<section class="col-med-4 col-sm-12 my-col" id="rightside">
				<article id="rightsidecontents">
					<h1>Register</h1>
					<h4>Don't have an account?</h4>
					<h4>Register Now!</h4>
					<button class="btn btn-primary" type="button" id="register">
						Register
					</button>
				</article>
			</section>
		</main>
	<?PHP } else {
		header("Location: ../posting/posts.html");
	} ?>
</body>

</html>