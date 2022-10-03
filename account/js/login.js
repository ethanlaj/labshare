(function () {
    "use strict";

    window.addEventListener("load", init);

    function init() {
        let button = document.getElementById("register");
        button.addEventListener("click", link);
    }

    function link() {
        window.location.href = "./register.html";
    }

})();