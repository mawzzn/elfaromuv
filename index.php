<?php
/**
 * Punto de entrada a la aplicación
 * Front Controller que gestiona todas las peticiones
 */

// Iniciar sesión
session_start();

// Controlador y acción por defecto
$controller = 'home';
$action = 'index';

// Obtener controlador de la URL
if (isset($_GET['controller'])) {
    $controller = strtolower($_GET['controller']);
}

// Obtener acción de la URL
if (isset($_GET['action'])) {
    $action = strtolower($_GET['action']);
}

// Formar el nombre del archivo del controlador
$controllerFile = 'controllers/' . ucfirst($controller) . 'Controller.php';

// Verificar si existe el controlador
if (file_exists($controllerFile)) {
    require_once $controllerFile;
    
    // Formar el nombre de la clase del controlador
    $controllerClass = ucfirst($controller) . 'Controller';
    
    // Crear instancia del controlador
    $objController = new $controllerClass();
    
    // Verificar si existe el método (acción)
    if (method_exists($objController, $action)) {
        // Ejecutar el método con parámetros si existen
        if (isset($_GET['id'])) {
            $objController->$action($_GET['id']);
        } else if (isset($_GET['id_categoria'])) {
            $objController->$action($_GET['id_categoria']);
        } else {
            $objController->$action();
        }
    } else {
        // Acción no encontrada, redirigir a la página principal
        header('Location: index.php');
    }
} else {
    // Controlador no encontrado, cargar controlador por defecto
    require_once 'controllers/HomeController.php';
    $objController = new HomeController();
    $objController->index();
}
?>