window.addEventListener("load", init);

function init() {
    let button = document.getElementById("submit");
    button.addEventListener("click", link);
}

function link() {
    window.location.href = "../profiles/createProfile.html";
}