<?php
require_once __DIR__ . '/../models/Estudiante.php';
require_once __DIR__ . '/../helpers/security.php';

class EstudianteController {
    private $modelo;

    public function __construct() {
        protegerPagina();
        $this->modelo = new Estudiante();
    }

    private function view($vista, $datos = []) {
        extract($datos);
        require __DIR__ . '/../views/layout/header.php';
        require __DIR__ . '/../views/' . $vista . '.php';
        require __DIR__ . '/../views/layout/footer.php';
    }

    public function index() {
        $estudiantes = $this->modelo->listarTodos();
        $this->view('estudiantes/index', ['estudiantes' => $estudiantes]);
    }

    public function create() {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['csrf_token'] ?? '';

            if (!validarTokenCSRF($token)) {
                $error = 'Token CSRF inválido.';
            } else {
                $nombre = trim($_POST['nombre'] ?? '');
                $email = trim($_POST['email'] ?? '');
                $password = $_POST['password'] ?? '';

                if ($nombre === '' || $email === '' || $password === '') {
                    $error = 'Todos los campos son obligatorios.';
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $error = 'El correo no tiene un formato válido.';
                } else {
                    try {
                        $this->modelo->crear($nombre, $email, $password);
                        header('Location: index.php?controller=estudiantes&action=index');
                        exit();
                    } catch (PDOException $e) {
                        $error = 'No se pudo registrar el estudiante. Verifica si el correo ya existe.';
                    }
                }
            }
        }

        $this->view('estudiantes/create', ['error' => $error]);
    }

    public function edit() {
        $id = (int)($_GET['id'] ?? 0);
        $estudiante = $this->modelo->buscarPorId($id);

        if (!$estudiante) {
            header('Location: index.php?controller=estudiantes&action=index');
            exit();
        }

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['csrf_token'] ?? '';

            if (!validarTokenCSRF($token)) {
                $error = 'Token CSRF inválido.';
            } else {
                $nombre = trim($_POST['nombre'] ?? '');
                $email = trim($_POST['email'] ?? '');
                $password = $_POST['password'] ?? '';

                if ($nombre === '' || $email === '') {
                    $error = 'Nombre y email son obligatorios.';
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $error = 'El correo no tiene un formato válido.';
                } else {
                    try {
                        $this->modelo->actualizar($id, $nombre, $email, $password);
                        header('Location: index.php?controller=estudiantes&action=index');
                        exit();
                    } catch (PDOException $e) {
                        $error = 'No se pudo actualizar el estudiante.';
                    }
                }
            }
        }

        $this->view('estudiantes/edit', ['error' => $error, 'estudiante' => $estudiante]);
    }

    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=estudiantes&action=index');
            exit();
        }

        $token = $_POST['csrf_token'] ?? '';
        $id = (int)($_POST['id'] ?? 0);

        if (validarTokenCSRF($token) && $id > 0) {
            $this->modelo->eliminar($id);
        }

        header('Location: index.php?controller=estudiantes&action=index');
        exit();
    }
}
