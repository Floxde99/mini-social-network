<?php

class CreatePostController extends Controller {
    private $postRepository;

    public function __construct() {
        $this->postRepository = new PostRepository();
    }

    public function index() {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            require '../view/posts/create.php';
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Changement des noms des champs pour correspondre au formulaire
                $titre = trim($_POST['title'] ?? '');
                $contenu = trim($_POST['content'] ?? '');

                if (empty($titre) || empty($contenu)) {
                    throw new Exception('Veuillez remplir tous les champs.');
                }

                $created = $this->postRepository->create(
                    $titre,
                    $contenu,
                    $_SESSION['user']['iduseur']
                );

                if (!$created) {
                    throw new Exception("Une erreur est survenue lors de la création du post.");
                }

                $_SESSION['success'] = "Post créé avec succès !";
                header('Location: /posts');
                exit;

            } catch (Exception $e) {
                $_SESSION['error'] = "Erreur : " . $e->getMessage();
                header('Location: /posts/create');
                exit;
            }
        }
    }
}