<?php
function router($connection)
{
    $controllerParam = $_GET['controller'] ?? null;
    $action = $_GET['action'] ?? null;
    $id = $_GET['id'] ?? null;

    if (!$controllerParam) return error('Controlador no especificado');

    $controllerPath = 'controllers/' . $controllerParam . 'Controller.php';

    if (!file_exists($controllerPath)) return error("Archivo del controlador no encontrado: $controllerPath");

    include_once $controllerPath;

    $parts = explode('/', $controllerParam);
    $classBaseName = end($parts);
    $controllerClass = $classBaseName . 'Controller';

    if (!class_exists($controllerClass)) return error("Clase del controlador no encontrada: $controllerClass");

    $controller = new $controllerClass();

    if (!$action) return error("Acción no especificada");

    if (!method_exists($controller, $action)) return error("La acción no existe");

    if ($action === 'addUserMembership') {
        $controller->$action($userId, $membershipId, $connection);
        return;
    }
    if ($id !== null) {
        $controller->$action($id, $connection);
    } else {
        $controller->$action($connection);
    }
}


function error($msg)
{
    echo "<h3>Error: $msg</h3>";
}
