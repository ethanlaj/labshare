(function () {
    "use strict";

    window.addEventListener("load", init);

    function init() {
        let form = document.getElementById("form");
        form.addEventListener("submit", checkForm);

        let register = document.getElementById('register');
        register.addEventListener('click', registerlink);
    }

    function checkForm(event) {
        event.preventDefault();
        let form = new FormData(this);
        fetch("../api/account/login.php", {
            method: 'post',
            body: form,
        })
            .then(checkStatus)
            .then(checkcredentials)
    }

    function checkStatus(response) {
        if (response.ok) {
            return response.json();
        } else {
            return Promise.reject(new Error(response.status + ": " + response.statusText));
        }
    }

    function checkcredentials(responseData) {
        let usernamealert = document.getElementById("usernamealert");
        usernamealert.innerText = "";
        document.getElementById("username").classList.remove('marginless');


        if (!responseData.user_verify || !responseData.password_verify) {
            usernamealert.innerText = "Incorrect Username or Password";
            document.getElementById("username").classList.add('marginless');

        } else if (responseData.user_verify && responseData.password_verify) {
            window.location.href = "../posting";
        }

    }

    function registerlink() {
        document.location.href = "./register.php";
    }


})();