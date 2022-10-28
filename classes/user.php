<?PHP
class User {
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

	function __construct($user_id, $username,
		$firstName, $lastName, $email,
		$phoneNumber, $birthday, $inactive) {

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
?>