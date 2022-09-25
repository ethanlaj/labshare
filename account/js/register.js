window.addEventListener("load", init);

function init() {
    let register = document.getElementById("register");
    register.addEventListener("click", registerLink);
}

function registerLink() {
    window.location.href = ".././register.html";
}