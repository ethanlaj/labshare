(function () {
	window.addEventListener("load", init);

	/**
	 * Initial function that is ran when the window loads
	 * Fetches users and calls the function to add them to the view
	 */
	function init() {
		const urlParams = new URLSearchParams(window.location.search);

		let search = urlParams.get("search");

		fetch("../api/profiles/search.php?search=" + (search ? search : ""))
			.then(checkStatus)
			.then((users) => {
				addUsersToView(users);
			})
			.catch((e) => console.log(e));
	}

	/**
	 * Populates the users table with users from the database
	 * @param {Array} users The users to be added to the table
	 */
	function addUsersToView(users) {
		let tbody = document.querySelector("#usersTable tbody");

		for (let user of users) {
			let tr = document.createElement("tr");
			tr.id = "user" + user.user_id;
			tr.classList.add("user");

			// User profilepic cell
			let profilePicCell = document.createElement("td");
			let userImg = document.createElement("img");
			userImg.src = user.profilepic;
			userImg.alt = user.username;
			profilePicCell.appendChild(userImg);
			profilePicCell.classList.add("profilePic");
			tr.appendChild(profilePicCell)

			// User username cell
			let usernameCell = document.createElement("td");
			usernameCell.innerText = user.username;
			usernameCell.classList.add("username");
			tr.appendChild(usernameCell);

			// User full name cell
			let fullNameCell = document.createElement("td");
			fullNameCell.innerText = user.fullName;
			tr.appendChild(fullNameCell);

			tr.addEventListener("click", directToUser);
			tbody.appendChild(tr);
		}

	}

	/**
	 * Function that is ran when a user row is clicked
	 * Directs the user to the user
	 */
	function directToUser() {
		let userID = Number(this.id.split("user")[1]);
		console.log("Directed to user " + userID);
		window.location = "../profiles/profile.php?id=" + userID
	}

	/**
	 * Helper function to return the response's result text if successful, otherwise
	 * returns the rejected Promise result with an error status and corresponding text
	 * @param {object} response - response to check for success/error
	 * @returns {object} - valid result json if response was successful, otherwise rejected
	 *                     Promise result
	 */
	function checkStatus(response) {
		if (response.ok) {
			return response.json();
		} else {
			return Promise.reject(new Error(response.status + ": " + response.statusText));
		}
	}
})();