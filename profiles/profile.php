<?PHP
session_start();


$current_user_id = isset($_SESSION["user"])
	? $_SESSION["user"] : null;

require_once(__DIR__ . "/../database/accountFunctions.php");


$profile = null;
if (isset($_GET["id"])) $profile = get_profile($_GET["id"]);
else if ($current_user_id) $profile = get_profile();
else {
	header("Location: ../account/login.php");
	die();
}


if ($profile) {
	$profpic = $profile->profilepic;
	$ban = $profile->banner;
	$collabs = getCollabs($profile->user_id);
}
if ($profile->user_id == $_SESSION["user"]) {
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<!--TODO: make title the user id of profile being viewed if it exists, otherwise give an error-->
	<title>
		<?PHP echo $profile ? $profile->fullName : "Invalid Profile" ?>
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
	<link rel="stylesheet" href="../stylesheets/global/global.css" />
	<script src="../scripts/global/global.js"></script>

	<link rel="stylesheet" href="../stylesheets/profiles/yourProfile.css" />
	<script src="../scripts/profiles/yourProfile.js"></script>

	<!--favicon-->
	<link rel="icon" type="image/x-icon" href="../images/LabShareLogo.png" />
</head>

<body>
	<div id="navbar"></div>

	<?PHP if ($profile) { ?>
		<header>
			<h1><?PHP echo $profile->fullName ?></h1>
			<?PHP if ($profile->user_id == $_SESSION["user"]) {
			?>

				<button class="btn btn-primary" type="button" id="edit">
					Edit Profile
				</button>
			<?PHP
			}
			?>
		</header>
		<main>
			<section id="flexContainer">
				<article id="picture">
					<a <?PHP if ($profile->user_id == $_SESSION["user"]) {
						?>href="./editpictures.php" <?PHP } ?>> <img id="background" src="<?PHP echo $ban ?>" alt="Background photo" /></a>
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
					$collab_usernames = array();
					foreach ($collabs as $collab) {
						if (++$i > 4) break;
						if ($profile->user_id == $collab->applicant_id) {
							$pic = $collab->posterpic;
							$username = $collab->poster_username;
							$collaborator_id = $collab->poster_id;
						} else if ($profile->user_id == $collab->poster_id) {
							$pic = $collab->applicant_pic;
							$username = $collab->applicant_username;
							$collaborator_id = $collab->applicant_id;
						}

						if (array_search($username, $collab_usernames) === false)
							array_push($collab_usernames, $username);
						else break;
					?>
						<tr>
							<td>
								<a href="<?php echo "./profile.php?id=$collaborator_id"; ?>">
									<img class='collabs' src="<?php echo $pic ?>" alt="<?php echo $username ?>" title=" <?php echo $username ?>">
								</a>
							</td>
						</tr>
					<?PHP
					}
					?>
				</table>
			</aside>
		</main>
	<?PHP } else { ?>
		<p>This profile has been deleted or does not exist.</p>
	<?PHP } ?>

	<div id="footer"></div>
</body>

</html>