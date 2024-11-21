<?php

namespace app\controllers;

use app\models\Post;

class PostController {
    public function getAllPosts() {
        $postModel = new Post();
        header("Content-Type: application/json");
        $posts = $postModel->getAllPosts();
        echo json_encode($posts);
        exit();
    }

    public function getPostByID($id) {
        $postModel = new Post();
        header("Content-Type: application/json");
        $post = $postModel->getPostById($id);
        echo json_encode($post);
        exit();
    }

    public function savePost() {
        $inputData = [
            'title' => $_POST['title'] ?? false,
            'content' => $_POST['content'] ?? false,
        ];

        $postModel = new Post();
        $postModel->savePost($inputData);

        http_response_code(200);
        echo json_encode(['success' => true]);
        exit();
    }

    public function updatePost($id) {
        if (!$id) {
            http_response_code(404);
            exit();
        }

        parse_str(file_get_contents('php://input'), $_PUT);

        $inputData = [
            'id' => $id,
            'title' => $_PUT['title'] ?? false,
            'content' => $_PUT['content'] ?? false,
        ];

        $postModel = new Post();
        $postModel->updatePost($inputData);

        http_response_code(200);
        echo json_encode(['success' => true]);
        exit();
    }

    public function deletePost($id) {
        if (!$id) {
            http_response_code(404);
            exit();
        }

        $postModel = new Post();
        $postModel->deletePost(['id' => $id]);

        http_response_code(200);
        echo json_encode(['success' => true]);
        exit();
    }

    public function postsView() {
        include '../public/assets/views/post/posts-view.html';
        exit();
    }

    public function postsAddView() {
        include '../public/assets/views/post/posts-add.html';
        exit();
    }

    public function postsEditView() {
        include '../public/assets/views/post/posts-edit.html';
        exit();
    }
}
