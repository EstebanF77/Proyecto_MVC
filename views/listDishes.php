<?php
include '../models/drivers/conexDB.php';
include '../models/entities/model.php';
include '../models/entities/dish.php';
include '../controller/dishesController.php';

use app\controller\DishesController;

$controller = new DishesController();
$dishes = $controller->getAllDishes();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Platos</title>
</head>

<body>
    <h1>Platos registrados</h1>
    <a href="formDishes.php">Crear nuevo plato</a>

    <table border="1" cellpadding="6">
        <thead>
            <tr>
                <th>Descripción</th>
                <th>Precio</th>
                <th>ID Categoría</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dishes as $dish): ?>
                <tr>
                    <td><?= $dish->get('description') ?></td>
                    <td>$<?= number_format($dish->get('price'), 2) ?></td>
                    <td><?= $dish->get('idCategory') ?></td>
                    <td>
                        <a href="formDishes.php?id=<?= $dish->get('id') ?>">Modificar</a>
                        <a href="actions/deleteDish.php?id=<?= $dish->get('id') ?>">
                            Eliminar
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="../index.php">Volver al inicio</a>
</body>

</html>
