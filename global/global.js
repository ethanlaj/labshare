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
		fetch("../global/api/updateSession.php", { method: 'POST', body: data })
			.then(checkStatus)
			.then((result) => {
				if (result.reload == true)
					location.reload();

				$("#navbar").load("../global/navbar.html", () => addNavbarFunctionality(result.logged_in == true));
			})
			.catch(e => console.error(e));

		document.addEventListener("keypress", handleEnterPress);

		$("#footer").load("../global/footer.html");
	}

	/**
	 * This function will fetch all the notifications
	 * from the api and add them to the notification sidebar
	 */
	async function loadNotifications() {
		await fetch("../global/api/getNotifications.php")
			.then(checkStatus)
			.then((notifications) => {
				let notiBody = document.querySelector("#notificationsBody");

				for (let noti of notifications) {
					let outerDiv = document.createElement("div");
					outerDiv.id = "notification" + noti.notification_id;
					outerDiv.classList.add("notification");

					let date = document.createElement("p");
					date.classList.add("date");
					date.innerText = noti.notification_date;

					let message = document.createElement("p");
					message.classList.add("message");
					let actionButtonsContainer = document.createElement("div");
					actionButtonsContainer.classList.add("actionButtons");

					let dismissButton = document.createElement("button");
					dismissButton.classList.add("btn", "btn-secondary", "dismiss");
					dismissButton.innerText = "Dismiss";

					let contactInfo;

					switch (noti.type) {
						case "NEW_APP": {
							let acceptButton = document.createElement("button");
							acceptButton.classList.add("btn", "btn-outline-success", "accept");
							acceptButton.innerText = "Accept";

							let declineButton = document.createElement("button");
							declineButton.classList.add("btn", "btn-outline-danger", "decline");
							declineButton.innerText = "Decline";

							actionButtonsContainer.appendChild(acceptButton);
							actionButtonsContainer.appendChild(declineButton);

							let username_link = `../profiles/profile.php?id=` + noti.applicant_id;
							let post_link = `../posting/post.php?id=` + noti.post_id;
							message.innerHTML =
								`<a href="${username_link}">${noti.applicant_username}</a> applied to <a href="${post_link}">${noti.title}</a>`;

							// Build contact info for applicant
							contactInfo = document.createElement("div");
							contactInfo.classList.add("contact-info");

							let contactInfoTitle = document.createElement("p");
							contactInfoTitle.classList.add("title");
							contactInfoTitle.innerText = "Contact Information";
							contactInfo.appendChild(contactInfoTitle);

							if (noti.applicant_email) {
								let applicantEmail = document.createElement("p");
								applicantEmail.classList.add("email");
								applicantEmail.innerText = `Email: ${noti.applicant_email}`;
								contactInfo.appendChild(applicantEmail);
							}

							if (noti.applicant_phone) {
								let applicantPhone = document.createElement("p");
								applicantPhone.classList.add("phone");
								applicantPhone.innerText = `Phone: ${noti.applicant_phone}`;
								contactInfo.appendChild(applicantPhone);
							}

							break;
						}
						case "APP_ACCEPT": {
							actionButtonsContainer.appendChild(dismissButton);

							let username_link = `../profiles/profile.php?id=` + noti.poster_id;
							let post_link = `../posting/post.php?id=` + noti.post_id;
							message.innerHTML =
								`<a href="${username_link}">${noti.poster_username}</a> accepted your application for <a href="${post_link}">${noti.title}</a>`;

							// Build contact info for poster
							contactInfo = document.createElement("div");
							contactInfo.classList.add("contact-info");

							let contactInfoTitle = document.createElement("p");
							contactInfoTitle.classList.add("title");
							contactInfoTitle.innerText = "Contact Information";
							contactInfo.appendChild(contactInfoTitle);

							if (noti.poster_email) {
								let applicantEmail = document.createElement("p");
								applicantEmail.classList.add("email");
								applicantEmail.innerText = `Email: ${noti.poster_email}`;
								contactInfo.appendChild(applicantEmail);
							}

							if (noti.poster_phone) {
								let applicantPhone = document.createElement("p");
								applicantPhone.classList.add("phone");
								applicantPhone.innerText = `Phone: ${noti.poster_phone}`;
								contactInfo.appendChild(applicantPhone);
							}

							break;
						}
						case "APP_DECLINE": {
							actionButtonsContainer.appendChild(dismissButton);

							let username_link = `../profiles/profile.php?id=` + noti.poster_id;
							let post_link = `../posting/post.php?id=` + noti.post_id;
							message.innerHTML =
								`<a href="${username_link}">${noti.poster_username}</a> declined your application for <a href="${post_link}">${noti.title}</a>`;

							break;
						}
						case "POST_SAVED": {
							actionButtonsContainer.appendChild(dismissButton);

							let post_link = `../posting/post.php?id=` + noti.post_id;
							message.innerHTML = `<a href="${post_link}">${noti.title}</a> has been saved ${noti.count} times!`;

							break;
						}
					}

					outerDiv.appendChild(date);
					outerDiv.appendChild(message);
					if (contactInfo) outerDiv.appendChild(contactInfo);
					outerDiv.appendChild(actionButtonsContainer);

					notiBody.appendChild(outerDiv);
				}
			})
			.catch(e => console.error(e));

		return;
	}

	/**
	 * Checks to see how many notifications are being displayed
	 * If there are none, it will add a message to the sidebar instead.
	 */
	function checkNotiCount() {
		let notiBody = document.querySelector("#notificationsBody");
		let notis = notiBody.querySelectorAll(".notification");

		if (notis.length == 0) {
			let msg = document.createElement("p");
			msg.innerText = "You're all caught up! Nothing to see here..."

			notiBody.appendChild(msg);
		}
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
	async function addNavbarFunctionality(logged_in) {
		// Navbar
		let postSearch = document.getElementById("postSearch");
		postSearch.addEventListener("click", function () { searchBar(1); });

		let userSearch = document.getElementById("userSearch");
		userSearch.addEventListener("click", function () { searchBar(2); });

		if (logged_in) {
			await loadNotifications().catch(console.error);
			checkNotiCount();

			// Sidebar
			let dismissButtons = document.querySelectorAll(".notification .actionButtons .dismiss");
			for (let button of dismissButtons)
				button.addEventListener('click', dismiss);

			let acceptButtons = document.querySelectorAll(".notification .actionButtons .accept");
			for (let button of acceptButtons)
				button.addEventListener('click', accept);

			let declineButtons = document.querySelectorAll(".notification .actionButtons .decline");
			for (let button of declineButtons)
				button.addEventListener('click', decline);

			document.getElementById("sidebarButton").hidden = false;

			// Other navbar buttons
			document.getElementById("logoutBtn").hidden = false;
			document.getElementById("myProfile").hidden = false;
			document.getElementById("savedPosts").hidden = false;
			document.getElementById("yourPosts").hidden = false;
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

			if (kind == 1)
				location.href = '../posting/posts.html?search=' + searchQuery;
		}
	}

	/**
	 * Dismisses a notification
	 */
	function dismiss() {
		this.disabled = true;
		let notification = $(this.closest('.notification'))[0];

		let data = new FormData();
		data.append("id", notification.id.split("notification")[1]);

		fetch("../global/api/dismiss.php", { method: 'POST', body: data })
			.then((resp) => checkStatus(resp, false))
			.then(() => {
				notification.remove();
				checkNotiCount();
			}).catch(console.error);
	}

	/**
	 * Accepts the application from a notification
	 */
	function accept() {
		this.disabled = true;
		let notification = $(this.closest('.notification'))[0];

		let data = new FormData();
		data.append("id", notification.id.split("notification")[1]);

		fetch("../global/api/accept.php", { method: 'POST', body: data })
			.then((resp) => checkStatus(resp, false))
			.then(() => {
				notification.remove();
				checkNotiCount();
			}).catch(console.error);
	}

	/**
	 * Declines the application from a notification
	 */
	function decline() {
		this.disabled = true;
		let notification = $(this.closest('.notification'))[0];

		let data = new FormData();
		data.append("id", notification.id.split("notification")[1]);

		fetch("../global/api/decline.php", { method: 'POST', body: data })
			.then((resp) => checkStatus(resp, false))
			.then(() => {
				notification.remove();
				checkNotiCount();
			}).catch(console.error);
	}

	/**
	 * Helper function to return the response's result json if successful, otherwise
	 * returns the rejected Promise result with an error status
	 * @param {object} response - response to check for success/error
	 * @param {boolean} json - When set to false, it will return the boolean instead of the json
	 * @returns {object} - json if response was successful, otherwise rejected Promise result
	 * @returns {boolean} - true if successful, otherwise rejected Promise result
	 */
	function checkStatus(response, json = true) {
		if (response.ok) {
			if (json)
				return response.json();
			else
				return true;
		} else {
			return Promise.reject(new Error(response.status + ": " + response.statusText));
		}
	}
})();