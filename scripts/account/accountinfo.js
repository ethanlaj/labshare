(function () {
    "use strict";

    window.addEventListener("load", init);

    function init() {
        let edit = document.getElementById("edit");
        edit.addEventListener("click", editprofile);
    }

    function editprofile() {
        document.location.href = "./editaccountinfo.php";
    }


})();