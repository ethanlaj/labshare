<?PHP
require_once("postFunctions.php");
require_once("userFunctions.php");

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

	// Not mapped in the DB
	public $comments;

	function __construct($db_object, $includeComments = false)
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
		$this->username = array_key_exists("username", $db_object)
			? $db_object["username"] : null;

		if ($includeComments)
			$this->comments = getCommentsForPost($this->post_id);
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
	public $reports;
	public $inactive;
	public $username;

	// Not mapped in the DB
	public $children;

	function __construct($db_object)
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

		$this->children = getRepliesToComment($this->comment_id);
	}
}

class User
{
	public $user_id;
	public $username;
	public $firstName;
	public $lastName;
	public $email;
	public $phoneNumber;
	public $birthday;
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

	function __construct(
		$user_id,
		$username,
		$firstName,
		$lastName,
		$email,
		$phoneNumber,
		$birthday,
		$inactive
	) {

		$this->user_id = $user_id;
		$this->username = $username;
		$this->firstName = $firstName;
		$this->lastName = $lastName;
		$this->email = $email;
		$this->phoneNumber = $phoneNumber;
		$this->birthday = $birthday;
		$this->inactive = $inactive;
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
		$achievements_interests
	) {

		$this->user_id = $user_id;
		$this->quals_degrees = $quals_degrees;
		$this->areaOfStudy = $areaOfStudy;
		$this->yearsOfStudy = $yearsOfStudy;
		$this->secondaryAreaOfStudy = $secondaryAreaOfStudy;
		$this->about = $about;
		$this->achievements_interests = $achievements_interests;
	}
}
