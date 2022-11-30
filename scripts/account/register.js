(function () {
    "use strict";


    window.addEventListener("load", init);

    /**
     * form is given event listener which links to correct location
     */
    function init() {
        let form = document.getElementById("form");
        form.addEventListener("submit", checkForm);
    }
    /**
     * 
     * @param {SubmitEvent} event 
     */
    function checkForm(event) {
        let form = new FormData(this);
        let message = document.getElementById("alert");
        let message2 = document.getElementById("alert2");
        message2.innerText = "";

        if (form.get('password') != form.get('password2')) {
            event.preventDefault();
            message.innerText = "Your passwords do not match!";
        }
        else if (form.get('password') == form.get('password2')) {
            message.innerText = "";
            event.preventDefault();
            fetch("../api/account/register.php", {
                method: 'post',
                body: form,
            })
                .then(checkStatus)
                .then(checkusername)
        }

    }

    function checkusername(responseData) {
        let message2 = document.getElementById("alert2");
        console.log(responseData.username_taken);
        if (responseData.username_taken) {
            message2.innerText = "Username is already taken!";
        } else if (!responseData.creation_successful) {
            message2.innerText = "Something went wrong. Please try different credentials";
        } else if (responseData.creation_successful && !responseData.username_taken) {
            document.location.href = '../profiles/profile.php';
        }
    }
    function checkStatus(response) {
        if (response.ok) {
            return response.json();
        } else {
            return Promise.reject(new Error(response.status + ": " + response.statusText));
        }
    }

})();