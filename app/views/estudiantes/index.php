<section class="card">
    <div class="section-header">
        <div>
            <h1>Estudiantes</h1>
            <p>Listado general de estudiantes registrados.</p>
        </div>
        <a class="button" href="index.php?controller=estudiantes&action=create">Nuevo estudiante</a>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($estudiantes as $estudiante): ?>
                    <tr>
                        <td><?= e($estudiante['id']) ?></td>
                        <td><?= e($estudiante['nombre']) ?></td>
                        <td><?= e($estudiante['email']) ?></td>
                        <td><?= e($estudiante['created_at']) ?></td>
                        <td class="actions">
                            <a href="index.php?controller=estudiantes&action=edit&id=<?= e($estudiante['id']) ?>">Editar</a>

                            <form method="POST" action="index.php?controller=estudiantes&action=delete" onsubmit="return confirm('¿Eliminar estudiante?');">
                                <?= campoCSRF() ?>
                                <input type="hidden" name="id" value="<?= e($estudiante['id']) ?>">
                                <button class="danger" type="submit">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <?php if (empty($estudiantes)): ?>
                    <tr>
                        <td colspan="5">No hay estudiantes registrados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
