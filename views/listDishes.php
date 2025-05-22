<?php
include '../models/drivers/conexDB.php';
include '../models/entities/model.php';
include '../models/entities/dish.php';
include '../models/entities/categories.php';
include '../controller/dishesController.php';
include '../controller/categoriesController.php';

use app\controller\CategoriesController;

use app\controller\DishesController;

$controller = new DishesController();
$dishes = $controller->getAllDishes();
$categoryController = new CategoriesController();
$categories = $categoryController->getAllCategories();

$categoryMap = [];
foreach ($categories as $cat) {
    $categoryMap[$cat->get('id')] = $cat->get('name');
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Platos</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Platos registrados</h1>
            <a href="formDishes.php" class="btn btn-primary">Crear nuevo plato</a>
        </div>

        <table>
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
                        <td class="price">$<?= number_format($dish->get('price'), 2) ?></td>
                        <td><?= $categoryMap[$dish->get('idCategory')] ?? 'Sin categoría' ?></td>
                        <td class="actions">
                            <a href="formDishes.php?id=<?= $dish->get('id') ?>" class="btn btn-warning">Modificar</a>
                            <a href="actions/deleteDish.php?id=<?= $dish->get('id') ?>" class="btn btn-danger" onclick="return confirm('¿Está seguro de eliminar este plato?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="../index.php" class="btn btn-secondary">Volver al inicio</a>
    </div>
</body>

</html>
