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
        if (form.get('password') != form.get('password2')) {
            event.preventDefault();
            message.innerText = "Your passwords do not match!";
        }
        event.preventDefault();
        fetch("../api/account/register.php", {
            method: 'post',
            body: form,
        })
            .then(checkStatus)
            .then(checkusername)
    }

    function checkusername(responseData) {
        console.log(responseData);
    }
    function checkStatus(response) {
        if (response.ok) {
            return response.json();
        } else {
            return Promise.reject(new Error(response.status + ": " + response.statusText));
        }
    }

})();