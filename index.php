<?php
require_once 'config/database.php';
require_once 'controllers/TableController.php';

// Obtener el controlador y la acción de la URL
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'table';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Crear instancia del controlador
$tableController = new TableController($conn);

// Ejecutar la acción correspondiente
switch ($action) {
    case 'create':
        $tableController->create();
        break;
    case 'update':
        $tableController->update();
        break;
    case 'delete':
        $tableController->delete();
        break;
    default:
        $tableController->index();
        break;
}
