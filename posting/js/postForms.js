(function () {
	"use strict";

	window.addEventListener('load', init);

	/**
	 * Initial function that is ran when the window loads
	 * Adds event listener to form
	 */
	function init() {
		let postForm = document.getElementById("postForm");
		postForm.addEventListener("submit", checkInputs);
	}

	/**
	 * Checks the form's input fields and does not allow
	 * submission of form if it does not meet requirements
	 * @param {SubmitEvent} event
	 */
	function checkInputs(event) {
		let title = document.getElementById('title');
		let content = document.getElementById('content');
		if (validateTitle(title) == false || validateContent(content) == false)
			event.preventDefault();
	}

	/**
	 * Checks to see if the title meets the length requirement
	 * @param {HTMLElement} titleElement 
	 * @returns {boolean}
	 * true = meets length requirement;
	 * false = does not meet length requirement
	 */
	function validateTitle(titleElement) {
		let str = titleElement.value;

		return (str.length >= 10 && str.length <= 50);
	};

	/**
	 * Checks to see if the content meets the length requirement
	 * @param {HTMLElement} contentElement 
	 * @returns {boolean}
	 * true = meets length requirement;
	 * false = does not meet length requirement
	 */
	function validateContent(contentElement) {
		let str = contentElement.value;

		return (str.length >= 50 && str.length <= 2000);
	};
})();