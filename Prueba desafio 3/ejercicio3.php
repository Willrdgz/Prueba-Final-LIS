
// EstudianteController.php

require_once 'models/EstudianteModel.php';

class EstudianteController {

    public function listar() {
        // Crear el modelo
        $modelo = new EstudianteModel();

        // Obtener estudiantes desde el Model
        $datos = $modelo->getAll();

        // Cargar la View y enviar los datos
        require_once 'views/estudiantes/lista.php';
    }
}


// EstudianteModel.php

class EstudianteModel {

    public function getAll() {
        // Simulación de datos que vendrían de la BD
        return [
            [
                'id' => 1,
                'nombre' => 'Carlos Pérez',
                'correo' => 'carlos@gmail.com'
            ],
            [
                'id' => 2,
                'nombre' => 'Ana López',
                'correo' => 'ana@gmail.com'
            ],
            [
                'id' => 3,
                'nombre' => 'Luis Hernández',
                'correo' => 'luis@gmail.com'
            ]
        ];
    }
}
<!-- views/estudiantes/lista.php -->

<h2>Lista de Estudiantes</h2>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Correo</th>
    </tr>

    <?php foreach ($datos as $estudiante): ?>
        <tr>
            <td><?php echo $estudiante['id']; ?></td>
            <td><?php echo $estudiante['nombre']; ?></td>
            <td><?php echo $estudiante['correo']; ?></td>
        </tr>
    <?php endforeach; ?>
</table>