<?PHP
ini_set("display_errors", 1);
error_reporting(E_ALL);

if (isset($_POST["user_id"])) {
	require_once("../../database/profileFunctions.php");

	$user_id = $_POST["user_id"];
	$quals_degrees = null;
    $areaOfStudy = null;
    $yearsOfStudy = null;
    $secondaryAreaOfStudy = null;
    $about = null;
    $achievements = null;

	if (array_key_exists("quals_degrees", $_POST)){
		$parent_id = $_POST["quals_degrees"];
    if (array_key_exists("areaOfStudy", $_POST)){
        $parent_id = $_POST["areaOfStudy"];   
    if (array_key_exists("yearsOfStudy", $_POST)){
        $parent_id = $_POST["yearsOfStudy"];   
    if (array_key_exists("secondaryAreaOfStudy", $_POST)){
        $parent_id = $_POST["secondaryAreaOfStudy"];   
    if (array_key_exists("about", $_POST)){
        $parent_id = $_POST["about"];   
    if (array_key_exists("achievements_interests", $_POST)){
        $parent_id = $_POST["achievements_interests"];   
    
        createProfile($user_id, $quals_degrees,$areaOfStudy,$yearsOfStudy,$secondaryAreaOfStudy,$about,$achievements_interests);
    


} else {
	header("HTTP/1.1 400 Invalid parameters");
}
