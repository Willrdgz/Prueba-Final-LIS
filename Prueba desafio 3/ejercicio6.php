<?php 
// api/estudiantes.php -GET
header('Content-Type: application/json; charset=UTF-8');    
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

try {
    $pdo = new PDO('mysql:host=localhost;dbname=edusv_acadamey;charset=utf8mb4', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     // consulta para obtener todos los estudiantes
    $sql = "SELECT id, nombre, email, created_at FROM estudiantes";
    
    $smtmt = $pdo->prepare($sql);
    $smtmt->execute();

    $estudiantes = $smtmt->fetchAll(PDO::FETCH_ASSOC);

    //repuesta exitosa
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'data' => $estudiantes
    ]);

} catch (PDOException $e) {
    //error de base de datos 
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error en la conexión a la base de datos: ' 
    ]);
    }