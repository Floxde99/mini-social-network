<?php
class LogoutController extends Controller {
    public function index() {
        // Détruire la session pour déconnecter l'utilisateur
        session_start();
        session_unset();
        session_destroy();

        // Supprimer le cookie remember_me
        if (isset($_COOKIE['remember_me'])) {
            setcookie(
                'remember_me',
                '',
                [
                    'expires' => time() - 3600, // Expire dans le passé
                    'path' => '/',
                    'secure' => true,
                    'httponly' => true,
                    'samesite' => 'Strict'
                ]
            );
        }

        // Rediriger vers la page de connexion
        header("Location: /login");
        exit();
    }
}