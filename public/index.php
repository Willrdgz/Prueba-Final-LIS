<?php
require_once __DIR__ . '/../app/helpers/security.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/EstudianteController.php';

$controller = $_GET['controller'] ?? null;
$action = $_GET['action'] ?? null;

if ($controller === null || $action === null) {
    if (estaLogueado()) {
        header('Location: index.php?controller=estudiantes&action=index');
    } else {
        header('Location: index.php?controller=auth&action=login');
    }
    exit();
}

switch ($controller) {
    case 'auth':
        $auth = new AuthController();

        if ($action === 'login') {
            $auth->login();
        } elseif ($action === 'logout') {
            $auth->logout();
        } else {
            http_response_code(404);
            echo 'Acción de autenticación no encontrada.';
        }
        break;

    case 'estudiantes':
        $estudiantes = new EstudianteController();

        if ($action === 'index') {
            $estudiantes->index();
        } elseif ($action === 'create') {
            $estudiantes->create();
        } elseif ($action === 'edit') {
            $estudiantes->edit();
        } elseif ($action === 'delete') {
            $estudiantes->delete();
        } else {
            http_response_code(404);
            echo 'Acción de estudiantes no encontrada.';
        }
        break;

    default:
        http_response_code(404);
        echo 'Controlador no encontrado.';
        break;
}
