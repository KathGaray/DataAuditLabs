<?php
class Router {
    private array $routes = [
        'auth'  => 'AuthController',
        'tarea' => 'TareaController',
    ];

    public function dispatch(): void {
        $controllerKey = $_GET['controller'] ?? 'auth';
        $action        = $_GET['action']     ?? 'mostrarLogin';

        if (!isset($this->routes[$controllerKey])) {
            $controllerKey = 'auth';
            $action        = 'mostrarLogin';
        }

        $controllerClass = $this->routes[$controllerKey];

        if (!class_exists($controllerClass)) {
            http_response_code(404);
            echo 'Controlador no encontrado.';
            exit;
        }

        $controller = new $controllerClass();

        if (!method_exists($controller, $action)) {
            http_response_code(404);
            echo 'Acción no encontrada.';
            exit;
        }

        $controller->$action();
    }
}
