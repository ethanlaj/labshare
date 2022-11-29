(function () {
	"use strict";

	window.addEventListener('load', init);
	let lastClickedComment;

	/**
	 * Initial function that is ran when the window loads
	 * Adds event listeners to:
	 * - Post buttons
	 * - Reply buttons
	 * - Comment buttons
	 */
	function init() {
		// Post buttons
		let savePostBtn = document.getElementById("savePostBtn");
		if (savePostBtn?.innerText == "Save")
			savePostBtn.addEventListener("click", savePost);
		else
			savePostBtn?.addEventListener("click", unsavePost);

		let applyToPostBtn = document.getElementById("applyToPostBtn");
		applyToPostBtn?.addEventListener("click", applyToPost);

		let reportPostBtn = document.getElementById("reportPostBtn");
		reportPostBtn?.addEventListener("click", reportPost);

		let deletePostBtn = document.getElementById("deletePostBtn");
		deletePostBtn?.addEventListener("click", deletePost);

		// Reply buttons
		let replyButtons = document.getElementsByClassName("replyButton");
		for (let replyButton of replyButtons)
			replyButton.addEventListener("click", startReply);

		let replyForms = document.getElementsByClassName("replyForm");
		for (let replyForm of replyForms)
			replyForm.addEventListener("submit", addReply);

		let cancelReplyButtons = document.getElementsByClassName("cancelReply");
		for (let cancelReplyButton of cancelReplyButtons)
			cancelReplyButton.addEventListener("click", cancelReply);

		// Comment buttons
		let initEditCommentBtns = document.querySelectorAll(".dropdown-item.edit");
		for (let initEditCommentBtn of initEditCommentBtns)
			initEditCommentBtn.addEventListener("click", initEditComment);

		let initDeleteCommentBtns = document.querySelectorAll(".dropdown-item.delete");
		for (let initDeleteCommentBtn of initDeleteCommentBtns)
			initDeleteCommentBtn.addEventListener("click", lastClicked);

		let initReportCommentBtns = document.querySelectorAll(".dropdown-item.report");
		for (let initReportCommentBtn of initReportCommentBtns)
			initReportCommentBtn.addEventListener("click", lastClicked);

		let reportCommentBtn = document.getElementById("reportCommentBtn");
		reportCommentBtn?.addEventListener("click", reportComment);

		let addCommentForm = document.getElementById("addCommentForm");
		addCommentForm?.addEventListener("submit", addComment);

		let editForm = document.getElementById("editForm");
		editForm?.addEventListener("submit", editComment);

		let deleteCommentBtn = document.getElementById("deleteCommentBtn");
		deleteCommentBtn?.addEventListener("click", deleteComment);
	}

	/**
	 * Shows a message in a modal
	 * @param {string} title The title of the modal
	 * @param {string} body The body text of the modal
	 */
	function showModal(title, body) {
		let titleEle = document.querySelector("#generalMessage .modal-title");
		let bodyEle = document.querySelector("#generalMessage .modal-body");

		titleEle.innerText = title;
		bodyEle.innerText = body;

		$("#generalMessage").modal("show");
	}

	/**
	 * Allows the last clicked comment to be tracked for use the
	 * comment action button modals.
	 */
	function lastClicked() {
		let comment = $(this.closest('.comment'))[0];

		lastClickedComment = comment;
	}

	/**
	 * Checks to see whether a reply has been started or not.
	 * If it has been started, then add the reply
	 * If not, then ignore
	 */
	function startReply() {
		let comment = $(this.closest('.comment'))[0];

		let replyStatus = comment.classList.contains('replying');

		if (replyStatus == false) {
			comment.classList.add('replying');

			comment.querySelector(".replyButton").classList.replace("btn-secondary", "btn-primary");
			comment.querySelector(".cancelReply").hidden = false;
			comment.querySelector(".replyBox").hidden = false;

			setTimeout(() => {
				comment.querySelector(".replyButton").type = "submit";
			}, 500);
		}
	}

	/**
	 * Adds a reply to a comment after form submission
	 */
	function addReply() {
		event.preventDefault();

		let comment = $(this.closest('.comment'))[0];
		let replyButton = comment.querySelector(".replyButton");
		replyButton.disabled = true;

		let reply = comment.querySelector('.replyBox');
		if (reply.value.trim() == "") {
			noReplyView(comment);
			return;
		}

		const urlParams = new URLSearchParams(window.location.search);

		let data = new FormData();
		data.append("post_id", urlParams.get("id"));
		data.append("content", reply.value);
		data.append("parent_id", comment.id.split("comment")[1]);

		fetch("../api/posting/addComment.php", { method: 'POST', body: data })
			.then(checkStatus)
			.then(() => {
				location.reload();
			}).catch((e) => {
				showModal("Failed to Add Comment", "Could not reply to comment, please try again later");
			});
	}

	/**
	 * Cancels a reply
	 */
	function cancelReply() {
		let comment = $(this.closest('.comment'))[0];

		noReplyView(comment);
	}

	/**
	 * Returns the comment to a non-reply view.
	 * @param {HTMLElement} comment - The comment that needs the view to be changed.
	 */
	function noReplyView(comment) {
		comment.classList.remove('replying');

		let replyButton = comment.querySelector(".replyButton");

		replyButton.classList.replace("btn-primary", "btn-secondary");
		replyButton.disabled = false;
		comment.querySelector(".cancelReply").hidden = true;
		comment.querySelector(".replyBox").hidden = true;

		setTimeout(() => {
			replyButton.type = "button";
		}, 500);
	}

	/**
	 * Saves the current post
	 */
	function savePost() {
		this.disabled = true;

		const urlParams = new URLSearchParams(window.location.search);

		let data = new FormData();
		data.append("post_id", urlParams.get("id"));

		fetch("../api/posting/save.php", { method: 'POST', body: data })
			.then(checkStatus)
			.then(() => {
				showModal("Successfully Saved", "You have successfully saved this post");
			}).catch((e) => {
				showModal("Failed to Save", "Could not save this post, please try again later");
			});
	}

	/**
	 * Saves the current post
	 */
	function unsavePost() {
		this.disabled = true;

		const urlParams = new URLSearchParams(window.location.search);

		let data = new FormData();
		data.append("post_id", urlParams.get("id"));

		fetch("../api/posting/unsave.php", { method: 'POST', body: data })
			.then(checkStatus)
			.then(() => {
				showModal("Successfully Unsaved", "You have successfully unsaved this post");
			}).catch((e) => {
				showModal("Failed to Unsave", "Could not unsave this post, please try again later");
			});
	}

	/**
	 * Applies to the current post
	 */
	function applyToPost() {
		this.disabled = true;

		const urlParams = new URLSearchParams(window.location.search);

		let data = new FormData();
		data.append("post_id", urlParams.get("id"));

		fetch("../api/posting/apply.php", { method: 'POST', body: data })
			.then(checkStatus)
			.then(() => {
				showModal("Successfully Applied", "You have successfully applied to this project");
			}).catch((e) => {
				showModal("Failed to Apply", "Could not apply to this project, please try again later");
			});
	}

	/**
	 * Reports the current post
	 */
	function reportPost() {
		this.disabled = true;

		const urlParams = new URLSearchParams(window.location.search);

		let data = new FormData();
		data.append("id", urlParams.get("id"));
		data.append("type", 1);

		fetch("../api/posting/report.php", { method: 'POST', body: data })
			.then(checkStatus)
			.then(() => {
				$("#reportPost").modal("hide");
				showModal("Report Received", "Thank you for your report");
			}).catch((e) => {
				showModal("Failed to Report Post", "Could not report post, please try again later");
			}).finally(() => this.disabled = false);
	}

	/**
	 * Deletes the current post
	 */
	function deletePost() {
		this.disabled = true;

		const urlParams = new URLSearchParams(window.location.search);

		let data = new FormData();
		data.append("post_id", urlParams.get("id"));

		fetch("../api/posting/deletePost.php", { method: 'POST', body: data })
			.then(checkStatus)
			.then(() => {
				window.location = "posts.html"
			}).catch((e) => {
				showModal("Failed to Delete Post", "Could not delete this post, please try again later");
			}).finally(() => this.disabled = false);
	}

	/**
	 * Reports a comment
	 */
	function reportComment() {
		this.disabled = true;

		let comment = lastClickedComment;

		let data = new FormData();
		data.append("id", comment.id.split("comment")[1]);
		data.append("type", 2);

		fetch("../api/posting/report.php", { method: 'POST', body: data })
			.then(checkStatus)
			.then(() => {
				$("#reportComment").modal("hide");
				showModal("Report Received", "Thank you for your report");
			}).catch((e) => {
				showModal("Failed to Report Comment", "Could not report comment, please try again later");
			}).finally(() => this.disabled = false)
	}

	/**
	 * Adds a comment to the post after form submission
	 */
	function addComment() {
		event.preventDefault();

		let addCommentBtn = document.querySelector("#addCommentBtn");
		addCommentBtn.disabled = true;

		let modalTextArea = document.getElementById("commentAddTextForm");

		const urlParams = new URLSearchParams(window.location.search);

		let data = new FormData();
		data.append("post_id", urlParams.get("id"));
		data.append("content", modalTextArea.value);

		fetch("../api/posting/addComment.php", { method: 'POST', body: data })
			.then(checkStatus)
			.then(() => {
				location.reload();
			}).catch((e) => {
				showModal("Failed to Add Comment", "Could not add comment, please try again later");
			}).finally(() => addCommentBtn.disabled = false);
	}

	/**
	 * Initializes the comment edit modal, changing the form field
	 * to match the comment's content and length
	 */
	function initEditComment() {
		let comment = $(this.closest('.comment'))[0];

		lastClickedComment = comment;

		let modalTextArea = document.getElementById("commentEditTextForm");
		let innerText = comment.querySelector('.commentContent').innerText;
		modalTextArea.value = innerText;

		// Update the size of the textarea based on the content:
		let breaks = innerText.split("\n").length;
		modalTextArea.rows = breaks + innerText.length / 35;

		$("#editComment").modal("show");
	}

	/**
	 * Edits a comment
	 */
	function editComment() {
		event.preventDefault();

		let editCommentBtn = document.querySelector("#editCommentBtn");
		editCommentBtn.disabled = true;

		let commentToEdit = lastClickedComment;
		let modalTextArea = document.getElementById("commentEditTextForm");

		let comment_id = commentToEdit.id.split("comment")[1];

		let data = new FormData();
		data.append("comment_id", comment_id);
		data.append("content", modalTextArea.value);

		fetch("../api/posting/editComment.php", { method: 'POST', body: data })
			.then(checkStatus)
			.then(() => {
				commentToEdit.querySelector('.commentContent').innerText = modalTextArea.value;
				$("#editComment").modal("hide");
			}).catch((e) => {
				showModal("Failed to Edit Comment", "Could not edit comment, please try again later");
			}).finally(() => editCommentBtn.disabled = false);
	}

	/**
	 * Deletes a comment
	 */
	function deleteComment() {
		this.disabled = true;

		let comment = lastClickedComment;
		let comment_id = comment.id.split("comment")[1];

		let data = new FormData();
		data.append("comment_id", comment_id);

		fetch("../api/posting/deleteComment.php", { method: 'POST', body: data })
			.then(checkStatus)
			.then(() => {
				location.reload();
			}).catch((e) => {
				showModal("Failed to Delete Comment", "Could not delete this comment, please try again later");
			}).finally(() => this.disabled = false);
	}

	/**
	 * Helper function to return true if successful, otherwise
	 * returns the rejected Promise result with an error status
	 * @param {object} response - response to check for success/error
	 * @returns {boolean} - true if response was successful, otherwise rejected
	 *                     Promise result
	 */
	function checkStatus(response) {
		if (response.ok) {
			return true;
		} else {
			return Promise.reject(new Error(response.status + ": " + response.statusText));
		}
	}
})();