<?php 
function listarEstudiantes() {
    try {
        // conexión a la base de datos
        $pdo = new PDO('mysql:host=localhost;dbname=edusv_acadamey;charset=utf8mb4', 'root', '');

    // activar errores de pdo 
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //consulta para listar todos los estudiantes
    $sql = "SELECT id, nombre, email, created_at FROM estudiantes";
    $smtmt = $pdo->prepare($sql);
    $smtmt->execute();

    //rertonar todos los registros 
    return $smtmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    return false;
    }
}

function actulizarEmail($id, $nuevoEmail) {
    try {
        // conexión a la base de datos
        $pdo = new PDO('mysql:host=localhost;dbname=edusv_acadamey;charset=utf8mb4', 'root', '');

        //activar errores de pdo
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //consulta para actualizar el email de un estudiante
        $sql = "UPDATE estudiantes SET email = :nuevoEmail WHERE id = :id";
        $stmt = $pdo->prepare($sql);

        //asignar valores 
        $stmt->bindParam(':nuevoEmail', $nuevoEmail, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        //ejecuta actulizacion 
        $stmt->execute();

        //retonar cuantas filas fueron 
        return $stmt->rowCount();

    } catch (PDOException $e) {
        return false;
    }
}