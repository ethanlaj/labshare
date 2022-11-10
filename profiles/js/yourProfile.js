(function () {
    "use strict";

    window.addEventListener("load", init);
    /**
     * edit button links to create profile page
     * recent post links link to example of post
     */
    function init() {
        let button = document.getElementById("edit");
        button.addEventListener("click", link);
        // let recentPosts = document.querySelectorAll('#recentposts td');
        // for (let i = 0; i < recentPosts.length; i++)
        //     recentPosts[i].addEventListener("click", post);

        // fetch("./api/getAllPosts.php")
        //     .then(checkStatus)
        //     .then((posts) => addPostsToView(posts))
    }
    /**
     * Function links to create profile page 
     */
    function link() {
        window.location.href = "./editprofile.php";
    }
    /**
     * Function links to example of post
     */
    function post() {

        window.location.href = "../posting/post.html";
    }
})();
