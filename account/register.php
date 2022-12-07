<?PHP require_once(__DIR__ . "/../global/validation.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Registration Page</title>
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

	<link rel="stylesheet" href="../stylesheets/account/register.css" />
	<script src="../scripts/account/register.js"></script>

	<!--favicon-->
	<link rel="icon" type="image/x-icon" href="../images/LabShareLogo.png" />
</head>

<body>

	<main id="registerform">
		<form id="form" action="../api/account/register.php" method="post">
			<article>
				<h1>Register</h1>
				<p>
					Don't have an account? Don't worry, registering will
					only take a minute
				</p>
			</article>
			<article>
				<label for="firstName" class="form-label">First Name</label>
				<input <?PHP echo convertToHTML($patterns["firstName"]); ?> type="text" class="form-control" name="firstName" id="firstName" />
			</article>
			<article>
				<label for="lastName" class="form-label">Last Name</label>
				<input <?PHP echo convertToHTML($patterns["lastName"]); ?> type="text" class="form-control" name="lastName" id="lastName" required />
			</article>
			<article>
				<label for="email" class="form-label">Email Address</label>
				<input <?PHP echo convertToHTML($patterns["email"]); ?> type="email" class="form-control" name="email" id="email" required />
			</article>
			<article>
				<label id="usernamelabel" for="userName" class="form-label">Username</label>
				<span> May only contain letters and numbers</span>
				<input <?PHP echo convertToHTML($patterns["username"]); ?> type="text" class="form-control" name="userName" id="userName" required />
				<p class="alert" id="usernamealert"></p>
			</article>
			<article>
				<label id="passwordlabel" for="password" class="form-label">Password</label>
				<span>Must contain at least 1 uppercase, 1 lowercase, 1 number, and 1 special character</span>
				<input <?PHP echo convertToHTML($patterns["password"]); ?> type="password" class="form-control" name="password" id="password" required />
				<p class="alert" id="passwordalert1"></p>
			</article>
			<article>
				<label id="password2label" for="password2" class="form-label">Enter Password Again</label>
				<input <?PHP echo convertToHTML($patterns["password"]); ?> type="password" class="form-control" name="password2" id="password2" required />
				<p class="alert" id="passwordalert2"></p>
			</article>
			<article>
				<label for="phone" class="form-label">Phone Number</label>
				<input <?PHP echo convertToHTML($patterns["phone"]); ?> type="tel" class="form-control" name="phone" id="phone" />
			</article>
			<article>
				<label for="birthday" class="form-label">Birthday</label>
				<input <?PHP echo convertToHTML($patterns["birthday"]); ?> type="date" class="form-control" name="birthday" id="birthday" required />
			</article>
			<article>
				<input class="btn btn-primary" type="submit" value="Submit" id="submit" />
			</article>
		</form>
	</main>
</body>

</html>