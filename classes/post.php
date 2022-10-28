<?PHP
class Post {
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
	function __construct($post_id, $creationDate, $author_id, $title, $content, $reports, $inactive) {
		$this->post_id = $post_id;
		$this->creationDate = $creationDate;
		$this->author_id = $author_id;
		$this->title = $title;
		$this->content = $content;
		$this->reports = $reports;
		$this->inactive = $inactive;

		$this->user = getUser($author_id);
	}
}
?>