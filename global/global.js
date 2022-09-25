window.onload = () => {
	$("#navbar").load("../global/navbar.html")
	//$("#footer").load("footer.html"); 
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

$(document).keypress(
	function (event) {
		if (event.which == '13') {
			event.preventDefault();

			let searchBarElement = document.getElementById("searchBarNav");
			if (document.activeElement == searchBarElement) {
				searchBar(1);
			}

		}
	});