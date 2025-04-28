<?php

class Router {
    public function start() {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $segments = explode('/', trim($uri, '/'));
        
        // Get controller name (default to 'main' if empty)
        $controllerSlug = !empty($segments[0]) ? $segments[0] : 'main'; // Changé de 'home' à 'main'
        
        // Convert kebab-case to PascalCase (retour-mail -> RetourMail)
        $controllerName = str_replace(' ', '', 
            ucwords(str_replace('-', ' ', $controllerSlug))
        ) . 'Controller';
        
        // Get action name (default to 'index')
        $action = isset($segments[1]) && $segments[1] !== '' ? $segments[1] : 'index';
        
        $controllerFile = "../src/controllers/{$controllerName}.php";
        
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            $controller = new $controllerName();
            if (method_exists($controller, $action)) {
                $controller->$action();
            } else {
                throw new Exception("Action {$action} not found in {$controllerName}");
            }
        } else {
            throw new Exception("Controller {$controllerName} not found");
        }
    }
}