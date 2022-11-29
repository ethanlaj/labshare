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
        event.preventDefault();
        let form = document.getElementById('form');
        fetch("../account/api/register.php", {
            method: 'post',
            body: new FormData(this),
        })
            .then(checkStatus)
            .then((response) => {
                console.log(response)
            })





    }
    function checkStatus(response) {
        if (response.ok) {
            return response.json();
        } else {
            return Promise.reject(new Error(response.status + ": " + response.statusText));
        }
    }

})();