<?PHP
function convertToLocal($datetime)
{
	$timestamp = strtotime($datetime . ' UTC');

	$date = new DateTime("@" . $timestamp);

	if (isset($_SESSION["timezone"])) {
		$date->setTimezone(new DateTimeZone($_SESSION["timezone"]));
	}

	return $date->format('m/d/Y \a\t g:ia');
}
