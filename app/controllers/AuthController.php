<?php
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../helpers/security.php';

class AuthController {
    private function view($vista, $datos = []) {
        extract($datos);
        require __DIR__ . '/../views/layout/header.php';
        require __DIR__ . '/../views/' . $vista . '.php';
        require __DIR__ . '/../views/layout/footer.php';
    }

    public function login() {
        if (estaLogueado()) {
            header('Location: index.php?controller=estudiantes&action=index');
            exit();
        }

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['csrf_token'] ?? '';

            if (!validarTokenCSRF($token)) {
                $error = 'Token CSRF inválido.';
            } else {
                $email = trim($_POST['email'] ?? '');
                $password = $_POST['password'] ?? '';

                $modelo = new Usuario();
                $usuario = $modelo->buscarPorEmail($email);

                if ($usuario && password_verify($password, $usuario['password'])) {
                    session_regenerate_id(true);

                    $_SESSION['usuario_id'] = $usuario['id'];
                    $_SESSION['usuario_nombre'] = $usuario['nombre'];
                    $_SESSION['usuario_email'] = $usuario['email'];
                    $_SESSION['usuario_rol'] = $usuario['rol'];

                    header('Location: index.php?controller=estudiantes&action=index');
                    exit();
                }

                $error = 'Correo o contraseña incorrectos.';
            }
        }

        $this->view('auth/login', ['error' => $error]);
    }

    public function logout() {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }

        session_destroy();
        header('Location: index.php?controller=auth&action=login');
        exit();
    }
}
