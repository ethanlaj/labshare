(function () {
	"use strict";

	const ZIPCODE_BASE_URL = "https://api.zippopotam.us/us/";

	window.addEventListener("load", init);

	/**
	 * Initial function that is ran when the window loads
	 * Fetches posts and calls the function to add them to the view
	 */
	function init() {
		const urlParams = new URLSearchParams(window.location.search);

		let type = urlParams.get("type");
		let search = urlParams.get("search");
		let zip = urlParams.get("zip");

		let extraParams = [];
		if (type)
			extraParams.push(`type=${type}`);
		if (search)
			extraParams.push(`search=${search}`);


		fetch("../api/posting/getAllPosts.php" + (extraParams.length > 0 ? "?" + extraParams.join("&") : ""))
			.then(checkStatus)
			.then((posts) => {
				if (zip)
					return sortByZip(posts, zip);

				addPostsToView(posts);
			})
			.catch((e) => console.log(e));

		if (type) {
			let upperType = type.charAt(0).toUpperCase() + type.slice(1);
			let str = upperType + " Posts";
			document.querySelector("header h2").innerText = str;
			document.title = str;
			document.querySelector("#zipCodeForm #type").value = type;
		}

		if (search) {
			document.querySelector("header h2").innerText = "Post Search Results";
			document.title = "Post Search Results";
			document.querySelector("#zipCodeForm #search").value = search;
		}
	}

	/**
	 * If a zip code is present in search parameters, 
	 * we will sort by distance on the front end. 
	 * @param {Array} posts All of the posts returned by the backend
	 * @param {string} zip The zip code to sort by
	 */
	async function sortByZip(posts, zip) {
		let selectedZipInfo = await getLatLon(zip);

		if (selectedZipInfo) {
			//posts = posts.filter(p => p.zip != null);
			posts = posts.sort((a, b) => compareDistances(a, b, selectedZipInfo));
		}

		addPostsToView(posts);
	}

	/**
	 * This function is used in the posts.sort() call.
	 * Suprisingly, this works even if a post does not
	 * have a zip code, as the getDistance function returns
	 * a value around 5000 miles.
	 * @param {object} a Post A
	 * @param {object} b Post B
	 * @param {object} selectedZipInfo An object containing the latitude and 
	 * longitude of the selected zip code
	 * @returns -1 if Post A is closer to the selected zip code than Post B;
	 * 1 if Post A is further away from the selected zip code than Post B;
	 * 0 if equal;
	 */
	function compareDistances(a, b, selectedZipInfo) {
		let distanceA = getDistance(a.lat, a.lon, selectedZipInfo.lat, selectedZipInfo.lon);
		let distanceB = getDistance(b.lat, b.lon, selectedZipInfo.lat, selectedZipInfo.lon)

		if (distanceA < distanceB) {
			return -1;
		}
		if (distanceA > distanceB) {
			return 1;
		}
		// a must be equal to b
		return 0;
	}

	/**
	 * Populates the posts table with posts from the database
	 * @param {Array} posts The posts to be added to the table
	 */
	function addPostsToView(posts) {
		let postsBody = document.querySelector("#posts");
		let tbody = document.querySelector("#postTable tbody");

		if (posts.length == 0) {
			let p = document.createElement("p");
			p.innerText = "No posts found";

			postsBody.appendChild(p);
			return;
		}

		for (let post of posts) {
			let tr = document.createElement("tr");
			tr.id = "post" + post.post_id;
			tr.classList.add("post");

			// User profilepic cell
			let profilePicCell = document.createElement("td");
			let userImg = document.createElement("img");
			userImg.src = post.profilepic;
			userImg.alt = post.username;
			profilePicCell.appendChild(userImg);
			profilePicCell.classList.add("profilePic");
			tr.appendChild(profilePicCell)

			// User username cell
			let usernameCell = document.createElement("td");
			let linkToProfile = document.createElement("a");
			linkToProfile.href = "../profiles/profile.php?id=" + post.author_id;
			linkToProfile.innerText = post.fullName;
			usernameCell.classList.add("username");
			usernameCell.appendChild(linkToProfile);
			tr.appendChild(usernameCell);

			// Post creation table cell
			let creationData = document.createElement("td");
			tr.appendChild(creationData);
			creationData.innerText = post.creationDate;

			// Post title table cell
			let titleData = document.createElement("td");
			tr.appendChild(titleData);
			titleData.innerHTML = post.title;

			// Zip code table cell
			let zipData = document.createElement("td");
			tr.appendChild(zipData);
			zipData.innerText = post.zip;

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
	 * This function gets the latitude and longitude of the selected zip code.
	 * @param {string} selectedZip - The zip code inputted by the user
	 * @returns {object} that contains the latitude and longitude of the zip code
	 */
	async function getLatLon(selectedZip) {
		// https://api.zippopotam.us/us/zipcode

		let selectedZipInfo = await fetch(ZIPCODE_BASE_URL + selectedZip).then((response) => {
			if (response.ok) {
				return response.json();
			} else {
				throw new Error("Response Failed")
			}
		}).then((result) => result.places[0])
			.catch(console.error);

		if (selectedZipInfo)
			return {
				lat: selectedZipInfo.latitude,
				lon: selectedZipInfo.longitude
			};
		else return null;
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


	// /**
	//  * Helper function to determine whether or not a file exists
	//  * @param {url} file 
	//  * @returns boolean true if file exists, false if it does not
	//  */
	// function fileExists(file) {
	// 	var http = new XMLHttpRequest();
	// 	http.open('HEAD', file, false);
	// 	http.send();
	// 	return http.status == 200;
	// }

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