window.addEventListener("load", init);

function init() {
    let login = document.getElementById("login");
    login.addEventListener("click", loginLink);

    let register = document.getElementById("register");
    register.addEventListener("click", registerLink);
}

function loginLink() {
    window.location.href = "../account/login.html";
}
function registerLink() {
    window.location.href = "../account/register.html";
}