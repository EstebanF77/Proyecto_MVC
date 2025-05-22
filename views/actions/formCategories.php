<?php
include '../../models/drivers/conexDB.php';
include '../../models/entities/model.php';
include '../../models/entities/categories.php';
include '../../controller/categoriesController.php';

use app\controller\CategoriesController;

$controller = new CategoriesController();
$category = null;

if (isset($_GET['id'])) {
    $category = $controller->getCategoryById($_GET['id']);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($_GET['id']) ? 'Modificar' : 'Registrar'; ?> Categoría</title>
</head>

<body>
    <h1><?php echo isset($_GET['id']) ? 'Modificar' : 'Registrar'; ?> Categoría</h1>
    
    <form action="registerCategories.php" method="post">
        <?php if (isset($_GET['id'])): ?>
            <input type="hidden" name="idCategorie" value="<?php echo $_GET['id']; ?>">
        <?php endif; ?>
        
        <div>
            <label for="name">Nombre de la categoría</label>
            <input type="text" id="name" name="name" max="10" 
                   value="<?php echo $category ? $category->get('name') : ''; ?>" required>
        </div>

        <div>
            <button type="submit"><?php echo isset($_GET['id']) ? 'Modificar' : 'Registrar'; ?></button>
            <a href="../categories.php">Cancelar</a>
        </div>
    </form>
</body>

</html>