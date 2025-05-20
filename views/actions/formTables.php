<?php
require_once 'config/database.php';
require_once 'models/Table.php';

$table = new Table($conn);

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'create':
                if (isset($_POST['name'])) {
                    $table->create($_POST['name']);
                }
                break;
            case 'update':
                if (isset($_POST['id']) && isset($_POST['name'])) {
                    $table->update($_POST['id'], $_POST['name']);
                }
                break;
            case 'delete':
                if (isset($_POST['id'])) {
                    $table->delete($_POST['id']);
                }
                break;
        }
    }
}

// Obtener todas las mesas
$tables = $table->getAll();
?>

<div class="container mt-4">
    <h2>Gestión de Mesas</h2>

    <!-- Formulario para crear nueva mesa -->
    <div class="card mb-4">
        <div class="card-header">
            <h4>Nueva Mesa</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="index.php?controller=table&action=create">
                <div class="form-group">
                    <label for="name">Nombre de la Mesa:</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Crear Mesa</button>
            </form>
        </div>
    </div>

    <!-- Lista de mesas existentes -->
    <div class="card">
        <div class="card-header">
            <h4>Mesas Existentes</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tables as $table): ?>
                        <tr>
                            <td><?php echo $table['id']; ?></td>
                            <td>
                                <form method="POST" action="index.php?controller=table&action=update" class="d-inline">
                                    <input type="hidden" name="id" value="<?php echo $table['id']; ?>">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="name" value="<?php echo $table['name']; ?>">
                                        <button type="submit" class="btn btn-warning">Actualizar</button>
                                    </div>
                                </form>
                            </td>
                            <td>
                                <form method="POST" action="index.php?controller=table&action=delete" class="d-inline" onsubmit="return confirm('¿Está seguro de eliminar esta mesa?');">
                                    <input type="hidden" name="id" value="<?php echo $table['id']; ?>">
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
