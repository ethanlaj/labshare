(function () {
	const ZIPCODE_BASE_URL = "https://api.zippopotam.us/us/";

	window.addEventListener("load", init);

	/**
	 * Initial function that is ran when the window loads
	 * Adds event listeners to posts
	 */
	function init() {
		fetch("./api/getAllPosts.php")
			.then(checkStatus)
			.then((posts) => addPostsToView(posts))

		let locationButton = document.querySelector("header h2");
		locationButton.addEventListener("click", getMilesBetween);
	}

	function addPostsToView(posts) {
		let tbody = document.querySelector("#postTable tbody");

		for (let post of posts) {
			let tr = document.createElement("tr");
			tr.id = "post" + post.post_id;
			tr.classList.add("post");

			// User table cell
			let userData = document.createElement("td");
			tr.appendChild(userData);

			let innerDiv = document.createElement("div");
			innerDiv.classList.add("user");
			userData.appendChild(innerDiv);

			let userImg = document.createElement("img");
			userImg.src = "../global/blank.jpg";
			userImg.alt = post.username;
			innerDiv.appendChild(userImg);

			linkToProfile = document.createElement("a");
			linkToProfile.href = "../profiles/yourProfile.php?id=" + post.author_id;
			linkToProfile.innerText = post.username;
			innerDiv.appendChild(linkToProfile);

			// Post creation table cell
			let creationData = document.createElement("td");
			tr.appendChild(creationData);
			creationData.innerText = post.creationDate;

			// Post title table cell
			let titleData = document.createElement("td");
			tr.appendChild(titleData);
			titleData.innerText = post.title;

			// Zip code table cell
			let zipData = document.createElement("td");
			tr.appendChild(zipData);
			zipData.innerText = "17022";

			tr.addEventListener("click", directToPost);
			tbody.appendChild(tr);
		}

	}

	/**
	 * Function that is ran when a post row is clicked
	 * Directs the user to the post
	 */
	function directToPost() {
		let postID = Number(this.id.split("post")[1]);
		console.log("Directed to post " + postID);
		window.location = "./post.php?id=" + postID
	}

	/**
	 * Called when each post is loaded, used to sort posts by the distance between
	 * the post and either the user's zip code or the zip code inputted.
	 * @param {string} postZip - The zip code of the post
	 * @param {string} selectedZip - The zip code of the user or the zip code inputted by the user
	 * @returns {double} distance - The distance between the two zip codes in miles
	 */
	async function getMilesBetween(postZip, selectedZip) {
		// https://api.zippopotam.us/us/zipcode

		postZip = "17022";
		selectedZip = "18073";

		let postZipInfo = await fetch(ZIPCODE_BASE_URL + postZip).then((response) => {
			if (response.ok) {
				return response.json();
			} else {
				throw new Error("Response Failed")
			}
		}).then((result) => result.places[0]);

		let selectedZipInfo = await fetch(ZIPCODE_BASE_URL + selectedZip).then((response) => {
			if (response.ok) {
				return response.json();
			} else {
				throw new Error("Response Failed")
			}
		}).then((result) => { console.log(result); return result.places[0] });

		let distance = getDistance(
			Number(postZipInfo.latitude),
			Number(postZipInfo.longitude),
			Number(selectedZipInfo.latitude),
			Number(selectedZipInfo.longitude)
		);

		return distance;
	}

	/**
	 * Calculates the distance between two coordinates
	 * @param {double} lat1 - Latitude of first coordinate pair
	 * @param {double} lng1 - Longitude of first coordinate pair
	 * @param {double} lat2 - Latitude of second coordinate pair
	 * @param {double} lng2 - Longitude of second coordinate pair
	 * @returns {double} distance - The distance between the two coordinates in miles
	 */
	function getDistance(lat1, lng1, lat2, lng2) {
		// https://stackoverflow.com/questions/18170131/comparing-two-locations-using-their-longitude-and-latitude
		// Thank you Philipp Jahoda on Stack Overflow!

		let earthRadius = 3958.75; // in miles, change to 6371 for kilometer output

		let dLat = toRadians(lat2 - lat1);
		let dLng = toRadians(lng2 - lng1);

		let sindLat = Math.sin(dLat / 2);
		let sindLng = Math.sin(dLng / 2);

		let a = Math.pow(sindLat, 2) + Math.pow(sindLng, 2)
			* Math.cos(toRadians(lat1)) * Math.cos(toRadians(lat2));

		let c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

		let dist = earthRadius * c;

		return dist; // output distance, in MILES
	}

	function toRadians(degrees) {
		// http://www.java2s.com/ref/javascript/javascript-math-toradians-degrees.html
		if (degrees < 0) {
			degrees += 360;
		}
		return degrees / 180 * Math.PI;
	};

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