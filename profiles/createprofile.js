window.addEventListener("load", init);

function init() {
    let submit = document.getElementById('submit');
    submit.addEventListener("click", submitForm);
}

function submitForm() {
    console.log('submit form to proper location');
}