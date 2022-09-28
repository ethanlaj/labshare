(function () {
	window.addEventListener("load", init);

	/**
	 * Initial function that is ran when the window loads
	 * Adds event listeners to posts
	 */
	function init() {
		let posts = document.querySelectorAll(".post");
		for (let post of posts)
			post.addEventListener("click", directToPost);
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
})();