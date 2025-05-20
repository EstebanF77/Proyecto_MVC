<?php
include '../models\drivers\conexDB.php';
include '../models\entities\model.php';
include '../models/entities/categories.php';
include '../models\entities\dish.php';
include '../controller/dishesController.php';
include '../controller/categoriesController.php';

use app\controller\DishesController;
use app\controller\CategoriesController;

$dish = null;
$idDish = $_GET['id'] ?? null;

$controller = new DishesController();
$catController = new CategoriesController();
$categories = $catController->getAllCategories();

// Si se está editando un plato
if ($idDish) {
    $dish = $controller->getDishById($idDish);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $dish ? 'Editar plato' : 'Registrar plato' ?></title>
</head>
<body>

<h1><?= $dish ? 'Editar plato' : 'Registrar plato' ?></h1>

<form action="actions/registerDishes.php" method="post">
    <?php if ($dish): ?>
        <input type="hidden" name="id" value="<?= $dish->get('id') ?>">
    <?php endif; ?>

    <div>
        <label for="descriptionDish">Descripción del plato</label>
        <input type="text" id="descriptionDish" name="descriptionDish" required 
               value="<?= $dish ? $dish->get('description') : '' ?>">
    </div>

    <div>
        <label for="categories">Categoría</label>
        <select id="categories" name="categories" required>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category->get('id') ?>" 
                    <?= $dish && $dish->get('idCategory') == $category->get('id') ? 'selected' : '' ?>>
                    <?= $category->get('nombre') ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <label for="unitPrice">Precio unitario</label>
        <input type="number" id="unitPrice" name="unitPrice" min="0" required
               value="<?= $dish ? $dish->get('price') : '' ?>">
    </div>

    <div>
        <button type="submit"><?= $dish ? 'Actualizar' : 'Registrar' ?></button>
    </div>
</form>
 
<a href="listDishes.php">Volver</a>
</body>
</html>
