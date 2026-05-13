<?php 
//api/estudiantes.php - multiples metodos 
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

function responderJSON($codigo, $datos) {
    http_response_code($codigo);
    echo json_encode($datos);
    exit();
}

try {
    $pdo = new PDO('mysql:host=localhost;dbname=edusv_acadamy;charset=utf8mb4', 'root', '');   
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //detectar metodo HTTP
    $metodo = $_SERVER['REQUEST_METHOD'];

    //obtener id desde la url o desde queyuery string
    $id = isset($_GET['id']) ? $_GET['id'] : null;

    switch ($metodo) {
        case 'GET':
            if ($id) {
                //obtener un estudiante por id
                $sql = "SELECT id, nombre, email, created_at FROM estudiantes WHERE id = :id";

                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                $estudiante = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($estudiante) {
                    responderJSON(200, ['success' => true, 'data' => $estudiante]);
                } else {
                    responderJSON(404, ['success' => false, 'message' => 'Estudiante no encontrado']);
                }
            } else {
                //obtener todos los estudiantes
                $sql = "SELECT id, nombre, email, created_at FROM estudiantes";

                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $estudiantes = $stmt->fetchAll(PDO::FETCH_ASSOC);
                responderJSON(200, ['success' => true, 'data' => $estudiantes]);
            }
            break;
        case 'POST':
            //recibe datos json 
            $input = json_decode(file_get_contents('php://input'), true);

            $nombre = $input['nombre'] ?? "";
            $email = $input['email'] ?? "";
            $password = $input['password'] ?? "";

            //validacion de datos 
            if (empty($nombre) || empty($email) || empty($password)) {
                responderJSON(400, ['success' => false, 'message' => 'Datos invalidos']);
            }
             if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                responderJSON(400, ['success' => false, 'message' => 'Email no valido']);
            }
            //hash de la contraseña
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            //insertar nuevo estudiante
            $sql = "INSERT INTO estudiantes (nombre, email, password) VALUES (:nombre, :email, :password)";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $passwordHash, PDO::PARAM_STR);

            $stmt->execute();

            responderJSON(201, ['success' => true, 'message' => 'Estudiante creado', 'id' => $pdo->lastInsertId()]);
            break;

            default:
                responderJSON(405, ['success' => false, 'message' => 'Metodo no permitido']);

                break;
            }
           
    }catch (PDOException $e) {
        responderJSON(500, ['success' => false, 'message' => 'Error interno del servidor : ' . $e->getMessage()]);
    }