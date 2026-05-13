<?php
class Database {
    private static $host = 'localhost';
    private static $dbname = 'edusv_academy';
    private static $user = 'root';
    private static $password = '';

    public static function conectar() {
        try {
            $pdo = new PDO(
                'mysql:host=' . self::$host . ';dbname=' . self::$dbname . ';charset=utf8mb4',
                self::$user,
                self::$password
            );

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            return $pdo;
        } catch (PDOException $e) {
            die('Error de conexión a la base de datos');
        }
    }
}
