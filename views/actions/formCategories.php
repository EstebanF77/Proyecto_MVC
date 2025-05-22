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
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <div class="container">
        <h1><?php echo isset($_GET['id']) ? 'Modificar' : 'Registrar'; ?> Categoría</h1>
        
        <div>
            <label for="name">Nombre de la categoría</label>
            <input type="text" id="name" name="name" maxlength="10"  
                   value="<?php echo $category ? $category->get('name') : ''; ?>" required>
        </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary">
                        <?php echo isset($_GET['id']) ? 'Modificar' : 'Registrar'; ?>
                    </button>
                    <a href="../categories.php" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>