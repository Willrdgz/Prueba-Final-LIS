<?php
require_once __DIR__ . '/../../config/database.php';

class Usuario {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::conectar();
    }

    public function buscarPorEmail($email) {
        $sql = 'SELECT id, nombre, email, password, rol FROM usuarios WHERE email = :email LIMIT 1';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch();
    }
}
