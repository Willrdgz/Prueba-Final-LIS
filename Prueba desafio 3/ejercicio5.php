<?php 
// 1 prevenir XSS con htmlspecialchars
function limpiarSalida($dato) {
    return htmlspecialchars($dato, ENT_QUOTES, 'UTF-8');
};

// 2 Token CSRF: generacion y verificacion
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function generarTokenCSRF() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function campoTokenCSRF() {
    $token = generarTokenCSRF();
    echo '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
}

function validarTokenCSRF($token) {
    if (!isset($_SESSION['csrf_token']) ) {
        return true;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

//3.hashear contraseña co password_hash
function hashearPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

function verificarPassword($password, $hash) {
    return password_verify($password, $hash);
}

?>