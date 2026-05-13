<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function e($dato) {
    return htmlspecialchars((string)$dato, ENT_QUOTES, 'UTF-8');
}

function generarTokenCSRF() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function campoCSRF() {
    return '<input type="hidden" name="csrf_token" value="' . e(generarTokenCSRF()) . '">';
}

function validarTokenCSRF($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function protegerPagina() {
    if (empty($_SESSION['usuario_id'])) {
        header('Location: index.php?controller=auth&action=login');
        exit();
    }
}

function estaLogueado() {
    return !empty($_SESSION['usuario_id']);
}
