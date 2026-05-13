<?php
// api/estudiantes.php - Endpoint REST con GET y POST

header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

require_once __DIR__ . '/../config/database.php';

function responderJSON($codigo, $datos) {
    http_response_code($codigo);
    echo json_encode($datos, JSON_UNESCAPED_UNICODE);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    responderJSON(200, ['success' => true]);
}

try {
    $pdo = Database::conectar();
    $metodo = $_SERVER['REQUEST_METHOD'];
    $id = isset($_GET['id']) ? (int)$_GET['id'] : null;

    switch ($metodo) {
        case 'GET':
            if ($id !== null && $id > 0) {
                $sql = 'SELECT id, nombre, email, created_at FROM estudiantes WHERE id = :id';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();

                $estudiante = $stmt->fetch();

                if ($estudiante) {
                    responderJSON(200, ['success' => true, 'data' => $estudiante]);
                }

                responderJSON(404, ['success' => false, 'message' => 'Estudiante no encontrado']);
            }

            $sql = 'SELECT id, nombre, email, created_at FROM estudiantes ORDER BY id DESC';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $estudiantes = $stmt->fetchAll();

            responderJSON(200, ['success' => true, 'data' => $estudiantes]);
            break;

        case 'POST':
            $input = json_decode(file_get_contents('php://input'), true);

            if (!is_array($input)) {
                responderJSON(400, ['success' => false, 'message' => 'JSON inválido']);
            }

            $nombre = trim($input['nombre'] ?? '');
            $email = trim($input['email'] ?? '');
            $password = $input['password'] ?? '';

            if ($nombre === '' || $email === '' || $password === '') {
                responderJSON(400, ['success' => false, 'message' => 'Datos inválidos']);
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                responderJSON(400, ['success' => false, 'message' => 'Email inválido']);
            }

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $sql = 'INSERT INTO estudiantes (nombre, email, password)
                    VALUES (:nombre, :email, :password)';

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $passwordHash, PDO::PARAM_STR);
            $stmt->execute();

            responderJSON(201, [
                'success' => true,
                'message' => 'Estudiante creado correctamente',
                'id' => $pdo->lastInsertId()
            ]);
            break;

        default:
            responderJSON(405, ['success' => false, 'message' => 'Método no permitido']);
    }
} catch (PDOException $e) {
    responderJSON(500, ['success' => false, 'message' => 'Error interno del servidor']);
}
