<section class="card login-card">
    <h1>Iniciar sesión</h1>
    <p>Acceso administrativo de EduSV Academy.</p>

    <?php if (!empty($error)): ?>
        <div class="alert error"><?= e($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php?controller=auth&action=login">
        <?= campoCSRF() ?>

        <label>Correo</label>
        <input type="email" name="email" placeholder="administrador@gmail.com" required>

        <label>Contraseña</label>
        <input type="password" name="password" placeholder="dsm104" required>

        <button type="submit">Entrar</button>
    </form>

    <small>Usuario de prueba: administrador@gmail.com / dsm104</small>
</section>
