CREATE DATABASE IF NOT EXISTS edusv_academy
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE edusv_academy;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol ENUM('admin', 'usuario') DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS estudiantes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Usuario administrador de prueba
-- Email: administrador@gmail.com
-- Password: dsm104
INSERT INTO usuarios (nombre, email, password, rol)
VALUES (
    'Administrador',
    'administrador@gmail.com',
    '$2y$12$3vWUzMSL0Budh5E93/nGGuv1f98sLNp/c6abCvAECZ0e7UeJosPV6',
    'admin'
)
ON DUPLICATE KEY UPDATE email = email;

-- Estudiante de prueba
-- Password: 123456
INSERT INTO estudiantes (nombre, email, password)
VALUES (
    'Estudiante Demo',
    'estudiante@demo.com',
    '$2y$12$sqXVCYRzoZeABSc9gD3HBeE3VvFEPo2EvpL7N329yjUTpXwgNINq6'
)
ON DUPLICATE KEY UPDATE email = email;
