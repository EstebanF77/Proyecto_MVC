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
</head>

<body>
    <h1>Mesas registradas</h1>
    <a href="actions/formTables.php">Crear nueva mesa</a>

    <table border="1" cellpadding="6">
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
                    <td>
                        <a href="actions/formTables.php?id=<?= $table->get('id') ?>">Modificar</a>
                        <a href="actions/deleteTables.php?id=<?= $table->get('id') ?>">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="../index.php">Volver al inicio</a>
</body>

</html>
