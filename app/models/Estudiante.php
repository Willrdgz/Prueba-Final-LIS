<?php
require_once __DIR__ . '/../../config/database.php';

class Estudiante {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::conectar();
    }

    public function listarTodos() {
        $sql = 'SELECT id, nombre, email, created_at FROM estudiantes ORDER BY id DESC';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function buscarPorId($id) {
        $sql = 'SELECT id, nombre, email, created_at FROM estudiantes WHERE id = :id LIMIT 1';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function crear($nombre, $email, $password) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $sql = 'INSERT INTO estudiantes (nombre, email, password)
                VALUES (:nombre, :email, :password)';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $passwordHash, PDO::PARAM_STR);
        $stmt->execute();

        return $this->pdo->lastInsertId();
    }

    public function actualizar($id, $nombre, $email, $password = null) {
        if (!empty($password)) {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $sql = 'UPDATE estudiantes
                    SET nombre = :nombre, email = :email, password = :password
                    WHERE id = :id';

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':password', $passwordHash, PDO::PARAM_STR);
        } else {
            $sql = 'UPDATE estudiantes
                    SET nombre = :nombre, email = :email
                    WHERE id = :id';

            $stmt = $this->pdo->prepare($sql);
        }

        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount();
    }

    public function actualizarEmail($id, $nuevoEmail) {
        $sql = 'UPDATE estudiantes SET email = :nuevoEmail WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':nuevoEmail', $nuevoEmail, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount();
    }

    public function eliminar($id) {
        $sql = 'DELETE FROM estudiantes WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount();
    }
}
