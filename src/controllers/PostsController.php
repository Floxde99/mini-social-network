<?php

class PostsController extends Controller {
    private $postRepository;

    public function __construct() {
        $this->postRepository = new PostRepository();
    }

    public function index() {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        try {
            $posts = $this->postRepository->findAll();
            $formattedPosts = [];
            foreach ($posts as $post) {
                $formattedPosts[] = $this->postRepository->formatPost($post);
            }

            require '../view/main.php';
        } catch (Exception $e) {
            $_SESSION['error'] = "Une erreur est survenue lors du chargement des posts.";
            error_log($e->getMessage());
            require '../view/main.php';
        }
    }
}