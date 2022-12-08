(function () {
    "use strict";

    window.addEventListener("load", init);

    /**
     * initialize function grabs form and register buttons as well as the input fields 
     */
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

    /**
     * @param mixed event
     * 
     * Function prevents form from sending and fetches the login api to test username and password before redirecting to home page
     */
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

    /**
     * @param response from login api
     * 
     * @return json formatted response from api
     */
    function checkStatus(response) {
        if (response.ok) {
            return response.json();
        } else {
            return Promise.reject(new Error(response.status + ": " + response.statusText));
        }
    }

    /**
     * @param response data from api
     * 
     * Function checks to to make sure that username and password are correct and redirects to home page if correct.
     * Otherwise, it creates an error response
     */
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