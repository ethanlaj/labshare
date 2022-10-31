(function () {
	"use strict";

	window.addEventListener('load', init);

	/**
	 * Initial function that is ran when the window loads
	 * Loads navbar and footers and
	 * Adds event listeners to:
	 * - Document (for keypresses)
	 */
	function init() {
		let data = new FormData();
		data.append("timezone", Intl.DateTimeFormat().resolvedOptions().timeZone);
		fetch("../global/updateSession.php", { method: 'POST', body: data })
			.then((res) => res.json())
			.then((json) => {
				if (json == true)
					location.reload();
			})
			.catch(e => console.error(e));

		document.addEventListener("keypress", handleEnterPress);
		$("#navbar").load("../global/navbar.html", addNavbarListeners);
		$("#footer").load("../global/footer.html");
	}

	/**
	 * Function that runs after the init function
	 * Adds event listeners to navbar buttons
	 */
	function addNavbarListeners() {
		// Navbar
		let postSearch = document.getElementById("postSearch");
		postSearch.addEventListener("click", function () { searchBar(1); });

		let userSearch = document.getElementById("userSearch");
		userSearch.addEventListener("click", function () { searchBar(2); });

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
	}

	/**
	 * Disables the default event for the Enter key
	 * Ensures that the search bar is working the right way
	 */
	function handleEnterPress(event) {
		if (event.which == '13') {
			event.preventDefault();

			let searchBarElement = document.getElementById("searchBarNav");
			if (document.activeElement == searchBarElement) {
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
})();