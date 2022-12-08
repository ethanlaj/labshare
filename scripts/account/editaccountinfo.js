(function () {
    "use strict";

    window.addEventListener("load", init);

    /**
     * initialize function grabs form and the input fields to add event listeners to check form and provide 
     * error feedback on input fields
     */
    function init() {
        let form = document.getElementById("form");
        form.addEventListener("submit", checkForm);

        form.addEventListener("input", (event) => {
            document.getElementById("password").classList.remove('shake');
        });
    }

    /**
     * @param submit event from form
     * 
     * Function stops form from sending and fetches checkCredentials api to make sure correct password
     */
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

    /**
     * @param response from api
     * @return json formatted response from api
     * Function checks response status of api response
     */
    function checkStatus(response) {
        if (response.ok) {
            return response.json();
        } else {
            return Promise.reject(new Error(response.status + ": " + response.statusText));
        }
    }

    /**
     * @param json formatted response from api
     * Function checks response from api and gives user error if incorrect, redirects if correct
     */
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