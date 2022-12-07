(function () {
    "use strict";

    window.addEventListener("load", init);

    function init() {
        let form = document.getElementById("form");
        form.addEventListener("submit", checkForm);

        let register = document.getElementById('register');
        register.addEventListener('click', registerlink);
        form.addEventListener("input", (event) => {
            document.getElementById("password").classList.remove('shake');
            document.getElementById("username").classList.remove('shake');
        });
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
        let username = document.getElementById("username");
        let password = document.getElementById("password");
        username.classList.remove('marginless');
        username.classList.remove('shake');
        password.classList.remove('shake');

        if (!responseData.loginSuccess) {
            usernamealert.innerText = "Incorrect Username or Password";
            document.getElementById("username").classList.add('marginless');
            setTimeout(
                function () {
                    username.classList.add("shake");
                    password.classList.add("shake");
                },
                10
            );

        } else if (responseData.loginSuccess) {
            window.location.href = "../posting/posts.html";
        }

    }

    function registerlink() {
        document.location.href = "./register.php";
    }


})();