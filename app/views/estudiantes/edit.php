<section class="card form-card">
    <h1>Editar estudiante</h1>

    <?php if (!empty($error)): ?>
        <div class="alert error"><?= e($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php?controller=estudiantes&action=edit&id=<?= e($estudiante['id']) ?>">
        <?= campoCSRF() ?>

        <label>Nombre</label>
        <input type="text" name="nombre" value="<?= e($estudiante['nombre']) ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?= e($estudiante['email']) ?>" required>

        <label>Nueva contraseña</label>
        <input type="password" name="password" placeholder="Dejar vacío para mantener la actual">

        <div class="form-actions">
            <button type="submit">Actualizar</button>
            <a class="button secondary" href="index.php?controller=estudiantes&action=index">Cancelar</a>
        </div>
    </form>
</section>
