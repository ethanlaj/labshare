(function () {
	const BASE_URL = "https://api.zippopotam.us/us/";

	window.addEventListener("load", init);

	/**
	 * Initial function that is ran when the window loads
	 * Adds event listeners to posts
	 */
	function init() {
		let posts = document.querySelectorAll(".post");
		for (let post of posts)
			post.addEventListener("click", directToPost);

		let locationButton = document.querySelector("header h2");
		locationButton.addEventListener("click", getMilesBetween);
	}

	/**
	 * Function that is ran when a post row is clicked
	 * Directs the user to the post
	 */
	function directToPost() {
		let postID = Number(this.id.split("post")[1]);
		console.log("Directed to post " + postID);
		window.location = "./post.html"
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

		let postZipInfo = await fetch(BASE_URL + postZip).then((response) => {
			if (response.ok) {
				return response.json();
			} else {
				throw new Error("Response Failed")
			}
		}).then((result) => result.places[0]);

		let selectedZipInfo = await fetch(BASE_URL + selectedZip).then((response) => {
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
})();