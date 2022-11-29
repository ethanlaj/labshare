<?php
// ini_set('allow_url_fopen');

$path_to_require = substr(@parse_url($_SERVER['REQUEST_URI'])['path'], 1);
switch (@parse_url($_SERVER['REQUEST_URI'])['path']) {
    case '/':
    case '/home':
        require 'home/index.html';
        break;
    case '/database/accountFunctions.php':
        require 'database/accountFunctions.php';
        break;
    case '/database/classes.php':
        require 'database/classes.php';
        break;
    case '/database/connect.php':
        require 'database/connect.php';
        break;
    case '/database/notificationFunctions.php':
        require 'database/notificationFunctions.php';
        break;
    case '/database/postFunctions.php':
        require 'database/postFunctions.php';
        break;
    case '/database/profileFunctions.php':
        require 'database/profileFunctions.php';
        break;
    case '/database/userFunctions.php':
        require 'database/userFunctions.php';
        break;

        /*
        // Account Views
    case '/account/changePassword.html':
        require 'account/changePassword.html';
        break;
    case '/account/login.php':
        require 'account/login.php';
        break;
    case '/account/logout.php':
        require 'account/logout.php';
        break;
    case '/account/register.php':
        require 'account/register.php';
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
        break;*/

    default:
        require $path_to_require;
        //http_response_code(404);
}
