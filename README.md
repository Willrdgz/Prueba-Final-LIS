# EduSV Academy - PHP MVC + MySQL

Sistema de gestión de estudiantes desarrollado en PHP puro con MySQL.

## Incluye

- CRUD completo de estudiantes con PDO y prepared statements.
- Arquitectura MVC con Model, View y Controller.
- Login seguro con sesiones PHP.
- Contraseñas protegidas con password_hash() y password_verify().
- Protección contra XSS con htmlspecialchars().
- Protección CSRF en formularios.
- API REST en PHP con respuestas JSON y códigos HTTP.

## Instalación en XAMPP

1. Copia la carpeta `edusv-academy` dentro de `htdocs`.
2. Abre phpMyAdmin.
3. Importa el archivo `database/edusv_academy.sql`.
4. Entra en el navegador a:

   `http://localhost/edusv-academy/public/`

## Usuario de prueba

- Correo: `administrador@gmail.com`
- Contraseña: `dsm104`

## API REST

Listar estudiantes:

`GET http://localhost/edusv-academy/api/estudiantes.php`

Buscar estudiante por ID:

`GET http://localhost/edusv-academy/api/estudiantes.php?id=1`

Crear estudiante:

`POST http://localhost/edusv-academy/api/estudiantes.php`

Body JSON:

```json
{
  "nombre": "Juan Pérez",
  "email": "juan@demo.com",
  "password": "123456"
}
```
