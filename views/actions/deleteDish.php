<?php
require_once '../../models/drivers/conexDB.php';
require_once '../../models/entities/model.php';
require_once '../../models/entities/dishes.php';
require_once '../../controller/DishesController.php';

use app\controller\DishesController;

$controller = new DishesController();
$res = $controller->deleteDish($_GET['id'] ?? null);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Eliminar plato</title>
    <link rel="stylesheet" href="../css/acciones.css">
</head>

<body>
    <h1>Resultado de la operación</h1>
    <?php
    switch ($res) {
    case 'yes':
        echo '<p class="msg-ok">Plato eliminado correctamente.</p>';
        break;
    case 'in_use':
        echo '<p class="msg-error">No se puede eliminar el plato porque está registrado en órdenes.</p>';
        break;
    case 'error':
    default:
        echo '<p class="msg-error">No se pudo eliminar el plato.</p>';
        break;
    }
    ?>
    <br>
    <a href="../listDishes.php">Volver</a>
</body>

</html>
