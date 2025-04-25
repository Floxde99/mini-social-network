<?php

class DeletePostController extends Controller {
    private $postRepository;

    public function __construct() {
        $this->postRepository = new PostRepository();
    }

    public function index() {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id'])) {
            header('Location: /posts');
            exit;
        }

        try {
            $idpost = (int)$_POST['id'];
            
            $deleted = $this->postRepository->delete(
                $idpost, 
                $_SESSION['user']['iduseur']
            );

            if (!$deleted) {
                throw new Exception("Post introuvable ou accès non autorisé.");
            }

            $_SESSION['success'] = "Post supprimé avec succès !";
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        header('Location: /posts');
        exit;
    }
}