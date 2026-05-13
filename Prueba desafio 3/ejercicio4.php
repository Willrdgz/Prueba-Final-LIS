<?php 
session_start();

//conexión a la base de datos
function conectarDB() {
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=edusv_acadamey;charset=utf8mb4', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
     }
     //1. procesa el login 
     function procesarLogin() {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $email = $_POST['email'];
                $password = $_POST['password'];

                $pdo = conectarDB();

                $sql = "SELECT id, nombre, email, password FROM estudiantes WHERE email = :email";

                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->execute();

                if ($stmt->rowCount() === 1) {
                    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
                    if (password_verify($password, $usuario['password'])) {
                        // Login exitoso
                        $_SESSION['user_id'] = $usuario['id'];
                        $_SESSION['user_name'] = $usuario['nombre'];
                        $_SESSION['user_email'] = $usuario['email'];
                        header('Location: dashboard.php');
                        exit();
                    } else {
                        echo "Contraseña incorrecta.";
                    }
                } else {
                    echo "Usuario no encontrado.";
                }
            }
        } catch (PDOException $e) {
            echo "Error en la conexión: " . $e->getMessage();
        }
     }

     // 2. middleware para proteger rutas
     function verificarSesion() {
         if (!isset($_SESSION['user_id'])) {
             header('Location: login.php');
             exit();
         }
         }
         
         //3. logout
         function logout() {
            session_unset();
            session_destroy();

            header('Location: login.php');
            exit();
            }
     }