<?php   
function insertarEstudiante($nombre, $email, $password) {

try {
    // conexión a la base de datos
    $pdo = new PDO('mysql:host=localhost;dbname=edusv_acadamey;charset=utf8mb4', 'root', '');

    // activar errores de pdo 
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //encriptar la contraseña
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    //consulta segura con prepared statements
    $sql = "INSERT INTO estudiantes (nombre, password, email) VALUES (:nombre, :password, :email)";
    $smtmt = $pdo->prepare($sql);

    //asigna valores 

    $smtmt->bindParam(':nombre', $nombre);
    $smtmt->bindParam(':email', $email);
    $smtmt->bindParam(':password', $hashed_password);

    //ejecutar la consulta
    $smtmt->execute();

    //retonar id insertado
    return $pdo->lastInsertId();
} catch (PDOException $e) {
    return false;
}
}