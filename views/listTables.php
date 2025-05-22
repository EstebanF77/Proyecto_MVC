<?php
include '../models/drivers/conexDB.php';
include '../models/entities/model.php';
include '../models/entities/table.php';
include '../controller/TableController.php';

use App\models\entities\Table;

$controller = new TableController();
$tables = $controller->getAll();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mesas</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Mesas registradas</h1>
            <a href="actions/formTables.php" class="btn btn-primary">Crear nueva mesa</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tables as $table): ?>
                    <tr>
                        <td><?= $table->get('name') ?></td>
                        <td class="actions">
                            <a href="actions/formTables.php?id=<?= $table->get('id') ?>" class="btn btn-warning">Modificar</a>
                            <a href="actions/deleteTables.php?id=<?= $table->get('id') ?>" class="btn btn-danger">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="../index.php" class="btn btn-secondary">Volver al inicio</a>
    </div>
</body>

</html>
