(function () {
    "use strict";

    window.addEventListener("load", init);
    /**
     * edit button links to create profile page
     * recent post links link to example of post
     */
    function init() {
        var uploadbanner = document.getElementById("banner");
        var uploadprofile = document.getElementById("profilepic");
        var submitbutton = document.getElementById("submit");

        uploadbanner.onchange = function () {
            if (this.files[0].size > 3000000) {//8388608
                document.getElementById("banneralert").innerText = "Image is too big";
                submitbutton.disabled = true;
            } else submitbutton.disabled = false;

        };
        uploadprofile.onchange = function () {
            if (this.files[0].size > 3000000) {//8388608
                document.getElementById("profpicalert").innerText = "Image is too big";
                submitbutton.disabled = true;
            } else submitbutton.disabled = false;
        };


    }
    /**
     * Function links to example of post
     */
    function post() {

        window.location.href = "../posting/post.html";
    }
})();
