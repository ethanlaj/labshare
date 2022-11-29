<?php
// ini_set('allow_url_fopen');

switch (@parse_url($_SERVER['REQUEST_URI'])['path']) {
    case '/':
    case '/home':
        require 'home/index.html';
        break;

        // Posting Views
    case '/posting/createPost.php':
        require 'posting/createPost.php';
        break;
    case '/posting/editPost.php':
        require 'posting/editPost.php';
        break;
    case '/posting/post.php':
        require 'posting/post.php';
        break;
    case '/posting/posts.html':
        require 'posting/posts.html';
        break;

    default:
        http_response_code(404);
}
