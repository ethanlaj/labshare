(function () {
    "use strict";

    window.addEventListener("load", init);

    /**
     * selects edit button and adds click event listener
     */
    function init() {
        let edit = document.getElementById("edit");
        edit.addEventListener("click", editprofile);
    }

    /**
     * redirects user to edit profile form
     */
    function editprofile() {
        document.location.href = "./editaccountinfo.php";
    }


})();