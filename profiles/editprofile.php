<?PHP
$profile = null;

ini_set("display_errors", 1);
error_reporting(E_ALL);

require_once("../database/accountFunctions.php");

$profile = get_profile();

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
	<link rel="stylesheet" href="../stylesheets/global/global.css" />
	<script src="../scripts/global/global.js"></script>

	<link rel="stylesheet" href="../stylesheets/createprofile.css" />
	<script src="../scripts/createprofile.js"></script>

	<!--favicon-->
	<link rel="icon" type="image/x-icon" href="../images/LabShareLogo.png" />
</head>

<body>
	<div id="navbar"></div>

	<form id="form" action="./api/editProfile.php" method="post">
		<div>
			<h1>Edit Profile</h1>
		</div>
		<div>
			<label for="qualifications" class="form-label">Qualifications/Degrees</label>
			<input type="text" value="<?PHP echo $profile->qualifications ?>" class="form-control" name="qualifications" id="qualifications" maxlength="45" required />
		</div>
		<div>
			<label for="areaofstudy" class="form-label">Area of Study</label>
			<input type="text" value="<?PHP echo $profile->areaofstudy ?>" class="form-control" name="areaofstudy" id="areaofstudy" maxlength="45" required />
		</div>
		<div>
			<label for="years" class="form-label">Years in field</label>
			<input type="text" value="<?PHP echo $profile->years ?>" class="form-control" name="years" id="years" maxlength="45" required />
		</div>
		<div>
			<label for="secondarea" class="form-label">Secondary Area of Study</label>
			<input type="text" value="<?PHP echo $profile->secondarea ?>" class="form-control" name="secondarea" id="secondarea" maxlength="45" required />
		</div>
		<div>
			<label for="summary" class="form-label">Summary/About Info</label>
			<textarea type="text" class="form-control" name="summary" id="summary" maxlength="250" required><?PHP echo $profile->summary ?></textarea>
		</div>
		<div>
			<label for="achievements" class="form-label">Achievements/Interests</label>
			<textarea type="text" class="form-control" name="achievements" id="achievements" maxlength="250" required><?PHP echo $profile->achievements ?></textarea>
		</div>

		<div>
			<input class="btn btn-primary" type="submit" value="Submit" id="submit" />
		</div>
	</form>

	<div id="footer"></div>
</body>

</html>