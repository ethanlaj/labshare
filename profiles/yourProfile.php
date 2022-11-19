<?PHP
$profile = null;

ini_set("display_errors", 1);
error_reporting(E_ALL);


require_once("../database/accountFunctions.php");

$profile = getprofile();
$profpic = null;
if ($profile->profilepic == null) {
	$profpic = "../global/noprofilepic.png";
} else $profpic = $profile->profilepic;
$collabs = getCollabs();
$ban = null;
if ($profile->banner == null) {
	$ban = "../global/defaultbanner.png";
} else $ban = $profile->banner;

$current_user_id = $_SESSION["user"];

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<!--TODO: make title the user id of profile being viewed if it exists, otherwise give an error-->
	<title>
		Profile
	</title>

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

	<link rel="stylesheet" href="./css/yourProfile.css" />
	<script src="./js/yourProfile.js"></script>

	<!--favicon-->
	<link rel="icon" type="image/x-icon" href="../global/LabShareLogo.png" />
</head>

<body>
	<div id="navbar"></div>

	<header>
		<h1><?PHP echo $profile->fullName ?></h1>
		<button class="btn btn-primary" type="button" id="edit">
			Edit Profile
		</button>
	</header>
	<main>
		<section id="flexContainer">
			<article id="picture">
				<a href="./editpictures.php"> <img id="background" src="<?PHP echo $ban ?>" alt="Background photo" /></a>
				<img id="profile" src="<?PHP echo $profpic ?>" alt="Name of User" />
			</article>
			<article>
				<table class="table">
					<tr>
						<th>Age</th>
						<td><?PHP echo $profile->age ?></td>
					</tr>
					<tr>
						<th>Qualifications/Degrees</th>
						<td>
							<?PHP echo $profile->qualifications ?>
						</td>
					</tr>
					<tr>
						<th>Area of Study</th>
						<td><?PHP echo $profile->areaofstudy ?></td>
					</tr>
					<tr>
						<th>Years in field</th>
						<td><?PHP echo $profile->years ?></td>
					</tr>
					<tr>
						<th>Secondary Area of Study</th>
						<td><?PHP echo $profile->secondarea ?></td>
					</tr>
				</table>
			</article>
			<article id="summary">
				<h4>Summary/About Info</h4>
				<p>
					<?PHP echo $profile->summary ?>
				</p>
			</article>
			<article id="achievements">
				<h4>Achievements/Interests</h4>
				<p>
					<?PHP echo $profile->achievements ?>
				</p>
			</article>
		</section>
		<aside id="topSideBar">
			<h5>Recent Collaborators</h5>
			<table id="collabstable">
				<?PHP
				$i = 0;
				while ($i < 4) {
					if (!$collabs) return;
					if (!array_key_exists($i, $collabs)) return;
					if ($current_user_id == $collabs[$i]["applicant_id"]) {
						$pic = $collabs[$i]["posterpic"];
					} else if ($current_user_id == $collabs[$i]["poster_id"]) {
						$pic = $collabs[$i]["applicant_pic"];
					} else
						$pic = null;
					echo "<tr>
					<td><a href='#'> <img class='collabs' src='$pic'></a></td>
				</tr>";
					$i++;
				}

				?>

			</table>
		</aside>
	</main>

	<div id="footer"></div>
</body>

</html>