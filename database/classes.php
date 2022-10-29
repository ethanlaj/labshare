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

	// Not mapped in the DB
	public $user;
	public $comments;

	/**
	 * Matches the Posts table in the database
	 * @param {int} post_id
	 * @param {Date} creationDate When the post was created
	 * @param {int} author_id Same as user_id
	 * @param {string} title
	 * @param {string} content
	 * @param {int} reports
	 * @param {boolean} inactive
	 */
	function __construct($post_id, $creationDate, $author_id, $title, $content, $reports, $inactive)
	{
		$this->post_id = $post_id;
		$this->creationDate = $creationDate;
		$this->author_id = $author_id;
		$this->title = $title;
		$this->content = $content;
		$this->reports = $reports;
		$this->inactive = $inactive;

		$this->user = getUser($author_id);
		$this->comments = getCommentsForPost($post_id);
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

	// Not mapped in the DB
	public $user;
	public $children;

	/**
	 * Matches the Comments table in the database
	 * @param {int} comment_id 
	 * @param {int} post_id 
	 * @param {int} author_id Matches user_id, this is the comment author.
	 * @param {Date} creationDate 
	 * @param {int} parent_id 
	 * @param {string} content 
	 * @param {int} reports 
	 * @param {boolean} inactive 
	 */

	function __construct(
		$comment_id,
		$post_id,
		$author_id,
		$creationDate,
		$parent_id,
		$content,
		$reports,
		$inactive
	) {

		$this->comment_id = $comment_id;
		$this->post_id = $post_id;
		$this->author_id = $author_id;
		$this->creationDate = $creationDate;
		$this->parent_id = $parent_id;
		$this->content = $content;
		$this->reports = $reports;
		$this->inactive = $inactive;

		$this->user = getUser($author_id);
		$this->children = getRepliesToComment($comment_id);
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
		$this->fullName = $firstName . " " . $lastName;
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
		$achievements_interests
	) {

		$this->user_id = $user_id;
		$this->quals_degrees = $quals_degrees;
		$this->areaOfStudy = $areaOfStudy;
		$this->yearsOfStudy = $yearsOfStudy;
		$this->secondaryAreaOfStudy = $secondaryAreaOfStudy;
		$this->about = $about;
		$this->achievements_interests = $achievements_interests;
		$this->user = getUser($user_id);
	}
}
