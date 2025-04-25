<?php

class MainController extends Controller {
    private $db;

    public function __construct() {
        $this->db = Db::getInstance();
    }

    public function index() {
        // Pour le moment, on peut laisser un tableau vide
        $posts = [];
        
        // Chargement de la vue
        require '../view/main.php';
    }
}