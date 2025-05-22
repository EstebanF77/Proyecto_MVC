<?php
include '../models\drivers\conexDB.php';
include '../models\entities\model.php';
include '../models\entities/categories.php';
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $dish ? 'Editar plato' : 'Registrar plato' ?></title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1><?= $dish ? 'Editar plato' : 'Registrar plato' ?></h1>

        <div class="form-container">
            <form action="actions/registerDishes.php" method="post">
                <?php if ($dish): ?>
                    <input type="hidden" name="id" value="<?= $dish->get('id') ?>">
                <?php endif; ?>

                <div>
                    <label for="descriptionDish">Descripción del plato</label>
                    <input type="text" id="descriptionDish" name="descriptionDish" required 
                           value="<?= $dish ? $dish->get('description') : '' ?>"
                           maxlength="100">
                </div>

                <div>
                    <label for="categories">Categoría</label>
                    <select id="categories" name="categories" required>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category->get('id') ?>" 
                                <?= $dish && $dish->get('idCategory') == $category->get('id') ? 'selected' : '' ?>>
                                <?= $category->get('name') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label for="unitPrice">Precio unitario</label>
                    <input type="number" id="unitPrice" name="unitPrice" min="1" step="0.01" required
                           value="<?= $dish ? $dish->get('price') : '' ?>">
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary">
                        <?= $dish ? 'Actualizar' : 'Registrar' ?>
                    </button>
                    <a href="listDishes.php" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
