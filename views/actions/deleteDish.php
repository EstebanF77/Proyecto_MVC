<?php
include '../../models/drivers/conexDB.php';
include '../../models/entities/model.php';
include '../../models/entities/dish.php';
include '../../controller/DishesController.php';

use app\controller\DishesController;

$controller = new DishesController();
$res = $controller->deleteDish($_GET['id'] ?? null);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Eliminar plato</title>
</head>

<body>
    <h1>Resultado de la operación</h1>
    <?php
    switch ($res) {
    case 'yes':
        echo '<p >Plato eliminado correctamente.</p>';
        break;
    case 'in_use':
        echo '<p >No se puede eliminar el plato porque está registrado en órdenes.</p>';
        break;
    case 'error':
    default:
        echo '<p >No se pudo eliminar el plato.</p>';
        break;
    }
    ?>
    <br>
    <a href="../listDishes.php">Volver</a>
</body>

</html>
