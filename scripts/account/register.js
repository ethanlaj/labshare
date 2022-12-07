(function () {
    "use strict";


    window.addEventListener("load", init);

    /**
     * form is given event listener which links to correct location
     */
    function init() {
        let form = document.getElementById("form");
        form.addEventListener("submit", checkForm);
        form.addEventListener("input", (event) => {
            document.getElementById("password").classList.remove('shake');
            document.getElementById("password2").classList.remove('shake');
        });

    }
    /**
     * 
     * @param {SubmitEvent} event 
     */
    function checkForm(event) {
        event.preventDefault();
        let form = new FormData(this);
        let password1 = document.getElementById("passwordalert1");
        let password2 = document.getElementById("passwordalert2");
        let inputpwd1 = document.getElementById("password");
        let inputpwd2 = document.getElementById("password2");

        password1.innerText = "";
        password2.innerText = "";
        password1.classList.remove('margin');
        password2.classList.remove('margin');
        inputpwd1.classList.remove('shake');
        inputpwd2.classList.remove('shake');


        if (form.get('password') != form.get('password2')) {
            password1.innerText = "Passwords do not match!";
            password2.innerText = "Passwords do not match!";
            password1.classList.add('margin');
            password2.classList.add('margin');
            inputpwd1.classList.add('shake');
            inputpwd2.classList.add('shake');

        }
        else if (form.get('password') == form.get('password2')) {
            password1.innerText = "";
            password2.innerText = "";

            fetch("../api/account/register.php", {
                method: 'post',
                body: form,
            })
                .then(checkStatus)
                .then(checkusername)
        }

    }

    function checkusername(responseData) {
        let useralert = document.getElementById("usernamealert");
        useralert.innerText = "";
        console.log(responseData.username_taken);
        if (responseData.username_taken) {
            useralert.innerText = "Username is already taken!";
        } else if (!responseData.creation_successful) {
            useralert.innerText = "Something went wrong. Please try different credentials";
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