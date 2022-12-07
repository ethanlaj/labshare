(function () {
    "use strict";

    window.addEventListener("load", init);

    function init() {
        let form = document.getElementById("form");
        form.addEventListener("submit", checkForm);

        form.addEventListener("input", (event) => {
            document.getElementById("password").classList.remove('shake');
        });
    }

    function checkForm(event) {
        event.preventDefault();
        let form = new FormData(this);
        fetch("../api/account/checkCredentials.php", {
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
        let alert = document.getElementById("alert");
        alert.innerText = "";
        let useralert = document.getElementById("useralert");
        useralert.innerText = "";
        let password = document.getElementById("oldpassword");
        password.classList.remove('shake');

        if (!responseData.password_verify) {
            alert.innerText = "Incorrect Password";
            setTimeout(
                function () {
                    password.classList.add("shake");
                },
                10
            );

        } else if (responseData.password_verify) {
            if (responseData.username_taken) {
                useralert.innerText = "Username Taken";
            } else
                window.location.href = "./accountinfo.php";
        }

    }


})();