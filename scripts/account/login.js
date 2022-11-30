(function () {
    "use strict";

    window.addEventListener("load", init);

    function init() {
        let form = document.getElementById("form");
        form.addEventListener("submit", checkForm);
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
        let passwordalert = document.getElementById("passwordalert");
        let usernamealert = document.getElementById("usernamealert");
        usernamealert.innerText = "";
        passwordalert.innerText = ""
        document.getElementById("username").classList.remove('marginless');


        if (!responseData.user_verify) {
            usernamealert.innerText = "Username is not recognized";
            document.getElementById("username").classList.add('marginless');

        } else if (!responseData.password_verify) {
            passwordalert.innerText = "Incorrect Password!"

        } else if (responseData.user_verify && responseData.password_verify) {
            window.location.href = "../home";
        }

    }


})();