window.onload = () => {
	$("#navbar").load("../global/navbar.html")
	$("#footer").load("../global/footer.html");
}

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
 * Disables the default event for the Enter key
 * Ensures that the search bar is working the right way
 */
$(document).keypress(
	function (event) {
		if (event.which == '13') {
			event.preventDefault();

			let searchBarElement = document.getElementById("searchBarNav");
			if (document.activeElement == searchBarElement) {
				searchBar(1);
			}

		}
	}
);