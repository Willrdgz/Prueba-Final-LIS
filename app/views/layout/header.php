<?php require_once __DIR__ . '/../../helpers/security.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduSV Academy</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="topbar">
    <div>
        <strong>EduSV Academy</strong>
        <span>Sistema de gestión de estudiantes</span>
    </div>

    <?php if (estaLogueado()): ?>
        <nav>
            <a href="index.php?controller=estudiantes&action=index">Estudiantes</a>
            <a href="../api/estudiantes.php" target="_blank">API JSON</a>
            <a href="index.php?controller=auth&action=logout">Cerrar sesión</a>
        </nav>
    <?php endif; ?>
</header>

<main class="container">
