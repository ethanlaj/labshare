window.addEventListener("load", init);

function init() {
    let form = document.getElementById("form");
    form.addEventListener("submit", link);
}
/**
 * 
 * @param {SubmitEvent} event 
 */
function link(event) {
    event.preventDefault();
    window.location.href = "../profiles/createProfile.html";

}