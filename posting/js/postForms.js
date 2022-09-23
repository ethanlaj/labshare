window.onload = () => {
	$("#postForm").submit(function (event) {
		let title = document.getElementById('title');
		let content = document.getElementById('content');

		if (validateTitle(title) == false || validateContent(content) == false)
			event.preventDefault();
	});
}

function validateTitle(titleElement) {
	let str = titleElement.value;

	return (str.length >= 10 && str.length <= 50);
}

function validateContent(contentElement) {
	let str = contentElement.value;

	return (str.length >= 50 && str.length <= 2000);
}