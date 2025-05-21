<?php
require_once '../../models/drivers/conexDB.php';
require_once '../../models/entities/model.php';
require_once '../../models/entities/order.php';
require_once '../../controller/OrderController.php';

use app\controller\OrderController;

$controller = new OrderController();
$res = $controller->cancel($_GET['id'] ?? null);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Anular Orden</title>
</head>
<body>
    <h1>Resultado de la operación</h1>
    <?php if ($res): ?>
        <p>Orden anulada correctamente.</p>
    <?php else: ?>
        <p>No se pudo anular la orden.</p>
    <?php endif; ?>
    <br>
    <a href="../listOrders.php">Volver</a>
</body>
</html> 