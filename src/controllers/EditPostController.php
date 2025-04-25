<?php

class EditPostController extends Controller {
    private $postRepository;

    public function __construct() {
        $this->postRepository = new PostRepository();
    }

    public function index() {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        $idpost = $_GET['id'] ?? null;

        if (!$idpost) {
            header('Location: /posts');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            try {
                $post = $this->postRepository->findById($idpost);

                if (!$post || $post['auteur'] !== $_SESSION['user']['iduseur']) {
                    throw new Exception("Post introuvable ou accès non autorisé.");
                }

                // Formatage pour la vue
                $post = [
                    'id' => $post['idpost'],
                    'title' => $post['titre'],
                    'content' => $post['contenu']
                ];

                require '../view/posts/edit.php';
                return;

            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
                header('Location: /posts');
                exit;
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $titre = trim($_POST['title'] ?? '');
                $contenu = trim($_POST['content'] ?? '');

                if (empty($titre) || empty($contenu)) {
                    throw new Exception('Veuillez remplir tous les champs.');
                }

                $updated = $this->postRepository->update(
                    $idpost,
                    $titre,
                    $contenu,
                    $_SESSION['user']['iduseur']
                );

                if (!$updated) {
                    throw new Exception("Une erreur est survenue lors de la modification du post.");
                }

                $_SESSION['success'] = "Post modifié avec succès !";
                header('Location: /posts');
                exit;

            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
                header("Location: /posts/edit?id=$idpost");
                exit;
            }
        }
    }
}