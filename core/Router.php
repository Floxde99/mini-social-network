<?php
class Router {
    public function start() {
        // 1. Récupérer le chemin sans base path
        $basePath = defined('BASE_PATH') ? BASE_PATH : '';
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        if ($basePath && strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath));
        }

        // 2. Découper et filtrer
        $segments = explode('/', trim($uri, '/'));
        $slugController = preg_replace('#[^a-z0-9\-]#i', '',
            $segments[0] ?? ''
        );
        $slugAction     = preg_replace('#[^a-z0-9_]#i', '',
            $segments[1] ?? ''
        );

        // 3. Defaults
        $controllerName = ($slugController ? $slugController : 'main');
        $controllerClass = str_replace(' ', '',
            ucwords(str_replace('-', ' ', $controllerName))
        ) . 'Controller';
        $action = $slugAction ?: 'index';

        // 4. Inclusion et exécution sécurisées
        $controllerFile = __DIR__ . '/../src/controllers/' 
                        . $controllerClass . '.php';
        if (!file_exists($controllerFile)) {
            return $this->error404();
        }

        require_once $controllerFile;
        if (!class_exists($controllerClass)) {
            return $this->error404();
        }

        $ctrl = new $controllerClass();
        if (!method_exists($ctrl, $action)) {
            return $this->error404();
        }

        // Appel
        $ctrl->$action();
    }

    protected function error404() {
        header("HTTP/1.0 404 Not Found");
        require __DIR__ . '/../view/error.php';
        exit;
    }
}
