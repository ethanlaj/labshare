window.addEventListener("load", init);

function init() {
    let button = document.getElementById("edit");
    button.addEventListener("click", link);
    let recentPosts = document.querySelector('#recentposts td');
    recentPosts.addEventListener("click", post)
}

function link() {
    window.location.href = "./createprofile.html";
}
function post() {
    console.log('Link to correct post');
}