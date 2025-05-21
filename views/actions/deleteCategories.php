<?php
include '../../models/drivers/conexDB.php';
include '../../models/entities/model.php';
include '../../models/entities/categories.php';
include '../../controller/categoriesController.php';

use app\controller\CategoriesController;

$controller = new CategoriesController();
$res = $controller->removeCategorie($_GET['id'] ?? null);

switch ($res) {
    case 'yes':
        $message = 'Categoría eliminada correctamente.';
        $type = 'success';
        break;
    case 'has_dishes':
        $message = 'No se puede eliminar esta categoría porque tiene platos asociados.';
        $type = 'error';
        break;
    case 'error':
    default:
        $message = 'No se pudo eliminar la categoría.';
        $type = 'error';
        break;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Eliminar categoría</title>
</head>

<body>
    <h1>Resultado de la operación</h1>
    <p style="color: <?= $type === 'success' ? 'green' : 'red' ?>">
        <?= $message ?>
    </p>
    <br>
    <a href="../categories.php">Volver</a>
</body>

</html> 