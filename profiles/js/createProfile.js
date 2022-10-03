window.addEventListener("load", init);
/**
 * form is given event listener
 */
function init() {
    let form = document.getElementById('form');
    form.addEventListener("submit", link);
}
/**
 * 
 * @param {SubmitEvent} event 
 */
function link(event) {
    event.preventDefault();
    window.location.href = "../posting/posts.html";

}
