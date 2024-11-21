<?php
require_once "../app/models/Model.php";
require_once "../app/models/User.php";
require_once "../app/models/Post.php";
require_once "../app/controllers/UserController.php";
require_once "../app/controllers/PostController.php";

// Set environment variables from .env file
$env = parse_ini_file('../.env');
define('DBNAME', $env['DBNAME']);
define('DBHOST', $env['DBHOST']);
define('DBUSER', $env['DBUSER']);
define('DBPASS', $env['DBPASS']);

use app\controllers\UserController;
use app\controllers\PostController;

// Get the URI without query strings
$uri = strtok($_SERVER["REQUEST_URI"], '?');

// Break the URI into pieces
$uriArray = explode("/", $uri);

// Users API
if ($uriArray[1] === 'api' && $uriArray[2] === 'users') {
    $userController = new UserController();

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $id = isset($uriArray[3]) ? intval($uriArray[3]) : null;
        if ($id) {
            $userController->getUserByID($id);
        } else {
            $userController->getAllUsers();
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userController->saveUser();
    } elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        $id = isset($uriArray[3]) ? intval($uriArray[3]) : null;
        $userController->updateUser($id);
    } elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        $id = isset($uriArray[3]) ? intval($uriArray[3]) : null;
        $userController->deleteUser($id);
    }
}

// Posts API
if ($uriArray[1] === 'api' && $uriArray[2] === 'posts') {
    $postController = new PostController();

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $id = isset($uriArray[3]) ? intval($uriArray[3]) : null;
        if ($id) {
            $postController->getPostByID($id);
        } else {
            $postController->getAllPosts();
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $postController->savePost();
    } elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        $id = isset($uriArray[3]) ? intval($uriArray[3]) : null;
        $postController->updatePost($id);
    } elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        $id = isset($uriArray[3]) ? intval($uriArray[3]) : null;
        $postController->deletePost($id);
    }
}

// User Views
if ($uri === '/users-add' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $userController = new UserController();
    $userController->usersAddView();
} elseif ($uriArray[1] === 'users-update' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $userController = new UserController();
    $userController->usersUpdateView();
} elseif ($uriArray[1] === 'users-delete' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $userController = new UserController();
    $userController->usersDeleteView();
} elseif ($uriArray[1] === '' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $userController = new UserController();
    $userController->usersView();
}

// Post Views
if ($uri === '/posts' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $postController = new PostController();
    $postController->postsView();
} elseif ($uri === '/posts-add' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $postController = new PostController();
    $postController->postsAddView();
} elseif ($uriArray[1] === 'posts-edit' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $postController = new PostController();
    $postController->postsEditView();
}

// If no route matches, show a not found page
include '../public/assets/views/notFound.html';
exit();

?>
