(function () {
    "use strict";


    window.addEventListener("load", init);
    /**
     * form is given event listener
     */
    function init() {

    }
    /**
     * 
     * @param {SubmitEvent} event 
     */
    function link(event) {
        event.preventDefault();
        window.location.href = "../posting/posts.html";

    }
})();