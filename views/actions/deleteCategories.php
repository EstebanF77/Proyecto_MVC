<?php
include '../../models/drivers/conexDB.php';
include '../../models/entities/model.php';
include '../../models/entities/categories.php';
include '../../controller/categoriesController.php';

use app\controller\CategoriesController;

$controller = new CategoriesController();
$res = $controller->removeCategorie($_GET['id'] ?? null);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Eliminar categoría</title>
</head>

<body>
    <h1>Resultado de la operación</h1>
    <?php
    switch ($res) {
        case 'yes':
            echo '<p>Categoría eliminada correctamente.</p>';
            break;
        case 'has_dishes':
            echo '<p>No se puede eliminar la categoría porque tiene platos asociados.</p>';
            break;
        case 'empty':
            echo '<p>La categoría no existe.</p>';
            break;
        case 'error':
        default:
            echo '<p>No se pudo eliminar la categoría.</p>';
            break;
    }
    ?>
    <br>
    <a href="../categories.php">Volver</a>
</body>

</html> 