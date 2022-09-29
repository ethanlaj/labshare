window.addEventListener("load", init);

function init() {
    let form = document.getElementById('form');
    form.addEventListener("submit", link);
}

function link(event) {
    event.preventDefault();
    window.location.href = "../posting/posts.html";

}
