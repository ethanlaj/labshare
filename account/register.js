window.addEventListener("load", init);

function init() {
    let login = document.getElementById("login");
    button.addEventListener("click", loginLink);

    let register = document.getElementById("register");
    register.addEventListener("click", registerLink);
}

function loginLink() {
    window.location.href = ".././login.html";
}
function registerLink() {
    window.location.href = ".././register.html";
}