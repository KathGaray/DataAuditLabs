<?php
session_start();

// Configuración
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

// Librerías
require_once __DIR__ . '/../libs/Auth.php';
require_once __DIR__ . '/../libs/Validator.php';
require_once __DIR__ . '/../libs/Router.php';

// Modelos
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Tarea.php';

// Controladores
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/TareaController.php';

// Enrutar
$router = new Router();
$router->dispatch();
