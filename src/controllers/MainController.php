<?php

class MainController extends Controller {
    public function index() {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }
        
        // Rediriger vers la liste des posts
        header('Location: /posts');
        exit;
    }
}