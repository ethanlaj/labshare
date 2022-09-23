function lastClicked(comment) {
	lastClickedComment = comment;
}

function startReply(comment) {
	let replyStatus = comment.getAttribute('replying');

	if (replyStatus == "false") {
		comment.setAttribute('replying', 'true');

		comment.querySelector(".replyButton").classList.remove("btn-secondary");
		comment.querySelector(".replyButton").classList.add("btn-primary");
		comment.querySelector(".cancelReply").hidden = false;
		comment.querySelector(".replyBox").hidden = false;
	} else {
		let reply = comment.querySelector('.replyBox');
		if (reply.value.trim() == "")
			return cancelReply(comment);

		console.log(`Replied to ${comment.id} with "${reply.value}"`);
		reply.value = "";
		cancelReply(comment);
	}
}

function cancelReply(comment) {
	comment.setAttribute('replying', 'false');

	comment.querySelector(".replyButton").classList.add("btn-secondary");
	comment.querySelector(".replyButton").classList.remove("btn-primary");
	comment.querySelector(".cancelReply").hidden = true;
	comment.querySelector(".replyBox").hidden = true;
}

function savePost() {
	console.log("Saved post");
	$("#save").modal("show");
}

function applyToPost() {
	console.log("Applied to post");
	$("#apply").modal("show");
}

function reportPost() {
	console.log("Reported post");
	$("#reportPost").modal("hide");
	$("#reportReceived").modal("show");
}

function deletePost() {
	console.log("Deleted post");
	$("#deletePost").modal("hide");
	$("#postDeleted").modal("show");
}

function reportComment(comment = lastClickedComment) {
	console.log(`Reported comment ${comment.id}`);
	$("#reportComment").modal("hide");
	$("#reportReceived").modal("show");
}

function addComment() {
	let modalTextArea = document.getElementById("commentAddTextForm");
	console.log(`Added comment ${modalTextArea.value}`)
	modalTextArea.value = "";

	$("#addComment").modal("hide");
}

function initEditComment(comment) {
	lastClickedComment = comment;

	let modalTextArea = document.getElementById("commentEditTextForm");
	let innerText = comment.querySelector('.commentContent').innerText;
	modalTextArea.value = innerText
	modalTextArea.rows = innerText.length / 35;

	$("#editComment").modal("show");
}

function saveEditComment() {
	let commentToEdit = lastClickedComment;
	let modalTextArea = document.getElementById("commentEditTextForm")

	commentToEdit.querySelector('.commentContent').innerText = modalTextArea.value;
	console.log(`Edited ${commentToEdit.id} to ${modalTextArea.value}`)
	$("#editComment").modal("hide");
}

function deleteComment(comment = lastClickedComment) {
	console.log(`Deleted comment ${comment.id}`);
	$("#deleteComment").modal("hide");
	$("#commentDeleted").modal("show");
}