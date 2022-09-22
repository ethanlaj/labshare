window.onload = () => {
	var postTitle = document.getElementById("postTitle");
	var postText = document.getElementById("postText");

	var postTitleForm = document.getElementById("postTitleForm");
	var postTextForm = document.getElementById("postTextForm");

	postTitleForm.setAttribute("value", postTitle.textContent);
	postTextForm.innerText = postText.textContent.trim();
}

function startReply() {
	// Determine if reply has already been started, if so, "post" reply.
	if (document.getElementsByClassName("cancelReply")[0].hidden == false)
		return cancelReply();

	document.getElementsByClassName("replyButton")[0].classList.remove("btn-secondary")
	document.getElementsByClassName("replyButton")[0].classList.add("btn-primary")
	document.getElementsByClassName("cancelReply")[0].hidden = false;
	document.getElementsByClassName("replyBox")[0].hidden = false;
}

function cancelReply() {
	document.getElementsByClassName("replyButton")[0].classList.add("btn-secondary")
	document.getElementsByClassName("replyButton")[0].classList.remove("btn-primary")
	document.getElementsByClassName("cancelReply")[0].hidden = true;
	document.getElementsByClassName("replyBox")[0].hidden = true;
}