<?PHP
require_once("sharedFunctions.php");
require_once("postFunctions.php");

class Post
{
	// Mapped in the DB
	public $post_id;
	public $creationDate;
	public $author_id;
	public $title;
	public $content;
	public $reports;
	public $inactive;
	public $username;
	public $fullName;
	public $profilepic;
	public $zip;
	public $lat;
	public $lon;

	// Not mapped in the DB
	public $comments = array();
	public $hasApplied;
	public $hasSaved;
	public $hasReported;

	function __construct($db_object, $includeExtraData = false)
	{
		$this->post_id = array_key_exists("post_id", $db_object)
			? $db_object["post_id"] : null;
		$this->creationDate = array_key_exists("creationDate", $db_object)
			? convertToLocal($db_object["creationDate"])
			: null;
		$this->author_id = array_key_exists("author_id", $db_object)
			? $db_object["author_id"] : null;
		$this->title = array_key_exists("title", $db_object)
			? $db_object["title"] : null;
		$this->content = array_key_exists("content", $db_object)
			? $db_object["content"] : null;
		$this->reports = array_key_exists("reports", $db_object)
			? $db_object["reports"] : null;
		$this->inactive = array_key_exists("inactive", $db_object)
			? $db_object["inactive"] : null;
		$this->zip = array_key_exists("zip", $db_object)
			? $db_object["zip"] : null;
		$this->lat = array_key_exists("lat", $db_object)
			? $db_object["lat"] : null;
		$this->lon = array_key_exists("lon", $db_object)
			? $db_object["lon"] : null;
		$this->username = array_key_exists("username", $db_object)
			? $db_object["username"] : null;
		$this->fullName = array_key_exists("fullName", $db_object)
			? $db_object["fullName"] : null;
		$this->profilepic = array_key_exists("profilepic", $db_object) && $db_object["profilepic"]
			? "https://storage.googleapis.com/user_pictures_folder/profilepics/" . $db_object["profilepic"]
			: "../images/noprofilepic.png";

		if ($includeExtraData) {
			$this->comments = getCommentsForPost($this->post_id);

			$this->hasApplied = applicationExists($this->post_id);
			$this->hasSaved = saveExists($this->post_id);
			$this->hasReported = reportExists($this->post_id, 1);
		}
	}
}

class Comment
{
	// Mapped in the DB
	public $comment_id;
	public $post_id;
	public $author_id;
	public $creationDate;
	public $parent_id;
	public $content;
	public $inactive;
	public $username;
	public $fullName;
	public $profilepic;
	public $reports;

	// Not mapped in the DB
	public $children = array();

	function __construct($db_object, $includeChildren = false)
	{
		$this->comment_id = array_key_exists("comment_id", $db_object)
			? $db_object["comment_id"] : null;
		$this->post_id = array_key_exists("post_id", $db_object)
			? $db_object["post_id"] : null;
		$this->author_id = array_key_exists("author_id", $db_object)
			? $db_object["author_id"] : null;
		$this->creationDate = array_key_exists("creationDate", $db_object)
			? convertToLocal($db_object["creationDate"])
			: null;
		$this->parent_id = array_key_exists("parent_id", $db_object)
			? $db_object["parent_id"] : null;
		$this->content = array_key_exists("content", $db_object)
			? $db_object["content"] : null;
		$this->reports = array_key_exists("reports", $db_object)
			? $db_object["reports"] : null;
		$this->inactive = array_key_exists("inactive", $db_object)
			? $db_object["inactive"] : null;
		$this->username = array_key_exists("username", $db_object)
			? $db_object["username"] : null;
		$this->fullName = array_key_exists("fullName", $db_object)
			? $db_object["fullName"] : null;
		$this->profilepic = array_key_exists("profilepic", $db_object) && $db_object["profilepic"]
			? "https://storage.googleapis.com/user_pictures_folder/profilepics/" . $db_object["profilepic"]
			: "../images/noprofilepic.png";

		if ($includeChildren)
			$this->children = getRepliesToComment($this->comment_id);
	}
}

class User
{
	public $user_id;
	public $username;
	public $firstName;
	public $lastName;
	public $fullName;
	public $email;
	public $phoneNumber;
	public $birthday;
	public $qualifications;
	public $areaofstudy;
	public $years;
	public $secondarea;
	public $summary;
	public $achievements;
	public $age;
	public $profilepic;
	public $banner;

	public $inactive;

	/**
	 * Matches the Users table in the database
	 * @param {int} user_id 
	 * @param {string} username 
	 * @param {string} firstName 
	 * @param {string} lastName 
	 * @param {string} email 
	 * @param {string} phoneNumber 
	 * @param {Date} birthday 
	 * @param {boolean} inactive
	 */

	function __construct($db_object)
	{
		$this->user_id = array_key_exists("user_id", $db_object)
			? $db_object["user_id"] : null;
		$this->username = array_key_exists("username", $db_object)
			? $db_object["username"] : null;
		$this->firstName = array_key_exists("firstName", $db_object)
			? $db_object["firstName"] : null;
		$this->lastName = array_key_exists("lastName", $db_object)
			? $db_object["firstName"] : null;
		$this->fullName = array_key_exists("firstName", $db_object) && array_key_exists("lastName", $db_object)
			? $db_object["firstName"] . " " . $db_object["lastName"] : null;
		$this->email = array_key_exists("email", $db_object)
			? $db_object["email"] : null;
		$this->phoneNumber = array_key_exists("phoneNumber", $db_object)
			? $db_object["phoneNumber"] : null;
		$this->birthday = array_key_exists("birthday", $db_object)
			? $db_object["birthday"] : null;
		$this->qualifications = array_key_exists("qualifications", $db_object)
			? $db_object["qualifications"] : null;
		$this->areaofstudy = array_key_exists("areaofstudy", $db_object)
			? $db_object["areaofstudy"] : null;
		$this->years = array_key_exists("years", $db_object)
			? $db_object["years"] : null;
		$this->secondarea = array_key_exists("secondarea", $db_object)
			? $db_object["secondarea"] : null;
		$this->summary = array_key_exists("summary", $db_object)
			? $db_object["summary"] : null;
		$this->achievements = array_key_exists("achievements", $db_object)
			? $db_object["achievements"] : null;
		$this->age = array_key_exists("age", $db_object)
			? $db_object["age"] : null;
		$this->profilepic = array_key_exists("profilepic", $db_object)
			? $db_object["profilepic"] : null;
		$this->banner = array_key_exists("banner", $db_object)
			? $db_object["banner"] : null;
	}
}

class Profile
{
	public $user_id;
	public $quals_degrees;
	public $areaOfStudy;
	public $yearsOfStudy;
	public $secondaryAreaOfStudy;
	public $about;
	public $achievements_interests;
	public $fullName;
	public $age;
	public $profilepic;
	public $banner;

	public $user;


	/**
	 * Matches the profiles table in the database
	 * @param {int} user_id
	 * @param {string} quals_degrees
	 * @param {string} areaOfStudy
	 * @param {string} yearsOfStudy
	 * @param {string} secondaryAreaOfStudy
	 * @param {string} about 
	 * @param {string} achievements_interests
	 * 
	 */
	function __construct(
		$user_id,
		$quals_degrees,
		$areaOfStudy,
		$yearsOfStudy,
		$secondaryAreaOfStudy,
		$about,
		$achievements_interests,
		$fullName,
		$age,
		$profilepic,
		$banner

	) {

		$this->user_id = $user_id;
		$this->quals_degrees = $quals_degrees;
		$this->areaOfStudy = $areaOfStudy;
		$this->yearsOfStudy = $yearsOfStudy;
		$this->secondaryAreaOfStudy = $secondaryAreaOfStudy;
		$this->about = $about;
		$this->achievements_interests = $achievements_interests;
		$this->fullName = $fullName;
		$this->age = $age;
		$this->profilepic = $profilepic;
		$this->banner = $banner;
	}
}

class Save
{
	public $user_id;
	public $post_id;

	/**
	 * Matches the Saves table in the database
	 * @param {int} user_id 
	 * @param {int} post_id 
	 */

	function __construct($user_id, $post_id)
	{
		$this->user_id = $user_id;
		$this->post_id = $post_id;
	}
}

class Application
{
	public $user_id;
	public $post_id;
	public $status;

	/**
	 * Matches the Applications table in the database
	 * @param {int} user_id 
	 * @param {int} post_id 
	 * @param {int} status
	 * AWAIT = Awaiting response;
	 * DECLINE = Declined;
	 * ACCEPT = Accepted;
	 */

	function __construct($user_id, $post_id, $status)
	{
		$this->user_id = $user_id;
		$this->post_id = $post_id;
		$this->status = $status;
	}
}

class Report
{
	public $reporter_id;
	public $id;
	public $type;

	/**
	 * Matches the Applications table in the database
	 * @param {int} reporter_id 
	 * @param {int} id
	 * ID of what the user reported
	 * @param {int} type
	 * 1 = Post;
	 * 2 = Comment;
	 */

	function __construct($reporter_id, $id, $type)
	{
		$this->reporter_id = $reporter_id;
		$this->id = $id;
		$this->type = $type;
	}
}

class Notification
{
	public $notification_id;
	public $notification_date;
	public $type;
	public $post_id;
	public $count;
	public $title;
	public $poster_id;
	public $poster_username;
	public $poster_email;
	public $poster_phone;
	public $applicant_id;
	public $applicant_username;
	public $applicant_email;
	public $applicant_phone;
	public $inactive;

	/**
	 * Matches the Advanced Notifications view in the database
	 * 
	 * kinds:
	 * NEW_APP = 'Application';
	 * APP_ACCEPT = Application accepted;
	 * APP_DECLINE = New comment on post;
	 * POST_SAVED = New reply to comment;
	 */

	function __construct($db_object)
	{
		$this->notification_id = array_key_exists("notification_id", $db_object)
			? $db_object["notification_id"] : null;
		$this->notification_date = array_key_exists("notification_date", $db_object)
			? convertToLocal($db_object["notification_date"])
			: null;
		$this->type = array_key_exists("type", $db_object)
			? $db_object["type"] : null;
		$this->count = array_key_exists("count", $db_object)
			? $db_object["count"] : null;
		$this->title = array_key_exists("title", $db_object)
			? $db_object["title"] : null;
		$this->post_id = array_key_exists("post_id", $db_object)
			? $db_object["post_id"] : null;
		$this->poster_id = array_key_exists("poster_id", $db_object)
			? $db_object["poster_id"] : null;
		$this->poster_username = array_key_exists("poster", $db_object)
			? $db_object["poster"] : null;
		$this->poster_email = array_key_exists("posterEmail", $db_object)
			? $db_object["posterEmail"] : null;
		$this->poster_phone = array_key_exists("posterPhone", $db_object)
			? $db_object["posterPhone"] : null;
		$this->applicant_id = array_key_exists("applicant_id", $db_object)
			? $db_object["applicant_id"] : null;
		$this->applicant_username = array_key_exists("applicant", $db_object)
			? $db_object["applicant"] : null;
		$this->applicant_email = array_key_exists("applicantEmail", $db_object)
			? $db_object["applicantEmail"] : null;
		$this->applicant_phone = array_key_exists("applicantPhone", $db_object)
			? $db_object["applicantPhone"] : null;
		$this->inactive = array_key_exists("inactive", $db_object)
			? $db_object["inactive"] : null;
	}
}

class Collab
{
	public $status;
	public $applicant_id;
	public $applicant_username;
	public $applicant_pic;
	public $poster_id;
	public $poster_username;
	public $posterpic;

	function __construct($db_object)
	{

		$this->status = array_key_exists("status", $db_object)
			? $db_object["status"] : null;
		$this->applicant_id = array_key_exists("applicant_id", $db_object)
			? $db_object["applicant_id"] : null;
		$this->applicant_username = array_key_exists("applicant_username", $db_object)
			? $db_object["applicant_username"] : null;
		$this->applicant_pic = array_key_exists("applicant_pic", $db_object)
			? $db_object["applicant_pic"] : null;
		$this->poster_id = array_key_exists("poster_id", $db_object)
			? $db_object["poster_id"] : null;
		$this->poster_username = array_key_exists("poster_username", $db_object)
			? $db_object["poster_username"] : null;
		$this->posterpic = array_key_exists("posterpic", $db_object)
			? $db_object["posterpic"] : null;
	}
}
