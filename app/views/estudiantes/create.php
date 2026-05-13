<section class="card form-card">
    <h1>Nuevo estudiante</h1>

    <?php if (!empty($error)): ?>
        <div class="alert error"><?= e($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php?controller=estudiantes&action=create">
        <?= campoCSRF() ?>

        <label>Nombre</label>
        <input type="text" name="nombre" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Contraseña</label>
        <input type="password" name="password" required>

        <div class="form-actions">
            <button type="submit">Guardar</button>
            <a class="button secondary" href="index.php?controller=estudiantes&action=index">Cancelar</a>
        </div>
    </form>
</section>
