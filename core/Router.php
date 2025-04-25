<?php

class Router
{
    public function start()
    {
        try {
            $uri = $_SERVER['REQUEST_URI'];
            
            // Gestion des paramètres GET
            $uriPath = parse_url($uri, PHP_URL_PATH);
            
            if ($uriPath !== "/") {
                // Convertir retour-mail en RetourMail pour le nom du contrôleur
                $controllerName = str_replace(' ', '', ucwords(str_replace('-', ' ', explode('/', $uriPath)[1]))) . "Controller";
                
                if (class_exists($controllerName)) {
                    $instance = new $controllerName();
                    $instance->index();
                } else {
                    include_once '../view/error.php';
                }
            } else {
                $instance = new LoginController();
                $instance->index();
            }
        } catch (\Throwable $th) {
            error_log($th->getMessage());
            include_once '../view/error.php';
        }
    }
}