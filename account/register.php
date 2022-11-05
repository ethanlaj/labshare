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
	<link rel="stylesheet" href="../global/global.css" />
	<script src="../global/global.js"></script>

	<link rel="stylesheet" href="./css/register.css" />
	<script src="./js/register.js"></script>

	<!--favicon-->
	<link rel="icon" type="image/x-icon" href="../global/LabShareLogo.png" />
</head>

<body>
	<main id="registerform">
		<form id="form" action="./api/register.php">
			<article>
				<h1>Register</h1>
				<p>
					Don't have an account? Don't worry, registering will
					only take a minute
				</p>
			</article>
			<article>
				<label for="firstName" class="form-label">Enter your first name</label>
				<input type="text" class="form-control" name="firstName" id="firstName" required />
			</article>
			<article>
				<label for="lastName" class="form-label">Enter your last name</label>
				<input type="text" class="form-control" name="lastName" id="lastName" required />
			</article>
			<article>
				<label for="email" class="form-label">Enter your email address</label>
				<input type="email" class="form-control" name="email" id="email" required />
			</article>
			<article>
				<label for="userName" class="form-label">Create your username</label>
				<input type="text" class="form-control" name="userName" id="userName" required />
			</article>
			<article>
				<label for="password" class="form-label">Create your password</label>
				<input type="text" class="form-control" name="password" id="password" required />
			</article>
			<article>
				<label for="phone" class="form-label">Enter your phone number</label>
				<input type="text" class="form-control" name="phone" id="phone" required />
			</article>
			<article>
				<label for="birthday" class="form-label">Birthday</label>
				<input type="date" class="form-control" name="birthday" id="birthday" required />
			</article>
			<article>
				<label for="qualifications" class="form-label">Qualifications/Degrees</label>
				<input type="text" class="form-control" name="qualifications" id="qualifications" minlength="2" maxlength="45" required />
			</article>
			<article>
				<label for="areaofstudy" class="form-label">Area of Study</label>
				<input type="text" class="form-control" name="areaofstudy" id="areaofstudy" minlength="2" maxlength="45" required />
			</article>
			<article>
				<label for="years" class="form-label">Years in Field</label>
				<input type="text" class="form-control" name="years" id="years" minlength="1" maxlength="45" required />
			</article>
			<article>
				<label for="secondfield" class="form-label">Secondary Area of Study</label>
				<input type="text" class="form-control" name="secondarea" id="secondarea" minlength="2" maxlength="45" required />
			</article>
			<article>
				<input class="btn btn-primary" type="submit" value="Submit" id="submit" />
			</article>
		</form>
	</main>
</body>

</html>