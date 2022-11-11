(function () {
	"use strict";

	window.addEventListener('load', init);

	/**
	 * Initial function that is ran when the window loads
	 * 
	 * Sends timezone data to the updateSession api
	 * 
	 * Loads navbar and footers and
	 * Adds event listeners to:
	 * - Document (for keypresses)
	 */
	function init() {
		let data = new FormData();
		data.append("timezone", Intl.DateTimeFormat().resolvedOptions().timeZone);
		fetch("../global/updateSession.php", { method: 'POST', body: data })
			.then(checkStatus)
			.then((result) => {
				if (result.reload == true)
					location.reload();

				$("#navbar").load("../global/navbar.html", () => addNavbarListeners(result.logged_in == true));
			})
			.catch(e => console.error(e));

		document.addEventListener("keypress", handleEnterPress);

		$("#footer").load("../global/footer.html");
	}

	/**
	 * Function that runs after the init function
	 * Adds event listeners to navbar buttons
	 * and shows certains part of the navbar
	 * depending on if the user is logged in or out
	 * 
	 * @param {boolean} logged_in: 
	 * 				true if the user is logged in,
	 * 				false if they are not logged in
	 */
	function addNavbarListeners(logged_in) {
		// Navbar
		let postSearch = document.getElementById("postSearch");
		postSearch.addEventListener("click", function () { searchBar(1); });

		let userSearch = document.getElementById("userSearch");
		userSearch.addEventListener("click", function () { searchBar(2); });

		if (logged_in) {
			// Sidebar
			let dismissButtons = document.querySelectorAll(".notification .actionButtons .dismiss");
			for (let button of dismissButtons)
				button.addEventListener('click', dismissButtonClick);

			let acceptButtons = document.querySelectorAll(".notification .actionButtons .accept");
			for (let button of acceptButtons)
				button.addEventListener('click', accept);

			let declineButtons = document.querySelectorAll(".notification .actionButtons .decline");
			for (let button of declineButtons)
				button.addEventListener('click', decline);

			document.getElementById("notifications").hidden = false;

			// Logout button
			document.getElementById("logoutBtn").hidden = false;
		} else {
			document.getElementById("loginBtn").hidden = false;
			document.getElementById("registerBtn").hidden = false;
		}
	}

	/**
	 * Disables the default event for the Enter key
	 * Ensures that the search bar is working the right way
	 */
	function handleEnterPress(event) {
		if (event.which == '13') {
			let searchBarElement = document.getElementById("searchBarNav");
			if (document.activeElement == searchBarElement) {
				event.preventDefault();
				searchBar(1);
			}
		}
	};

	/**
	 * Grabs the user's search input and redirects to the search result page.
	 * @param {int} kind - 1 is a post search, 2 is a user search
	 */
	function searchBar(kind) {
		let searchBarElement = document.getElementById("searchBarNav");

		let searchQuery = searchBarElement.value;
		searchQuery = searchQuery.trim();

		if (searchQuery != "") {
			console.log(`User requested a ${kind == 1 ? "post" : "user"} search: ${searchQuery}`);
			searchBarElement.value = "";
		}
	}

	/**
	 * Handles the clicking of the dismiss button
	 */
	function dismissButtonClick() {
		let notification = $(this.closest('.notification'))[0];
		dismiss(notification);
	}

	/**
	 * Dismisses the notification
	 * @param {HTMLElement} notification - The notification to be dismissed
	 */
	function dismiss(notification) {
		console.log("Dismiss notification: " + notification.id);
	}

	/**
	 * Accepts the application from the notification
	 */
	function accept() {
		let notification = $(this.closest('.notification'))[0];
		console.log("Accept notification: " + notification.id);

		dismiss(notification);
	}

	/**
	 * Declines the application from the notification
	 */
	function decline() {
		let notification = $(this.closest('.notification'))[0];
		console.log("Decline notification: " + notification.id);

		dismiss(notification);
	}

	/**
	 * Helper function to return the response's result text if successful, otherwise
	 * returns the rejected Promise result with an error status
	 * @param {object} response - response to check for success/error
	 * @returns {boolean} - true if response was successful, otherwise rejected Promise result                
	 */
	function checkStatus(response) {
		if (response.ok) {
			return response.json();
		} else {
			return Promise.reject(new Error(response.status + ": " + response.statusText));
		}
	}
})();