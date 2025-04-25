<?php

class Router {
    public function start() {
        try {
            $uri = $_SERVER['REQUEST_URI'];
            $uriPath = parse_url($uri, PHP_URL_PATH);

            // Diviser l'URI en segments
            $segments = array_values(array_filter(explode('/', $uriPath)));

            if (empty($segments)) {
                // Page d'accueil
                $controllerName = 'MainController';
                $action = 'index';
            } else {
                // Route personnalisée pour les actions directes
                $first = $segments[0];
                if (in_array($first, ['create-post', 'edit-post', 'delete-post'])) {
                    $controllerName = str_replace(' ', '', ucwords(str_replace('-', ' ', $first))) . 'Controller';
                    $action = 'index';
                } else {
                    // Convention classique
                    $controller = ucfirst($segments[0]);
                    $controllerName = $controller . 'Controller';
                    $action = $segments[1] ?? 'index';
                }
            }

            // Vérifier si le contrôleur existe
            if (!class_exists($controllerName)) {
                throw new Exception('Page non trouvée');
            }

            $instance = new $controllerName();

            // Vérifier si la méthode existe
            if (!method_exists($instance, $action)) {
                throw new Exception('Action non trouvée');
            }

            // Appeler la méthode
            $instance->$action();

        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            require '../view/error.php';
        }
    }
}