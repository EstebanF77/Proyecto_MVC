<?php
require_once '../controller/OrderController.php';
$orderController = new OrderController();
$orders = $orderController->getAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Órdenes</title>
</head>
<body>
    <h1>Órdenes registradas</h1>
    <a href="actions/formOrders.php">Registrar nueva orden</a>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Mesa</th>
                <th>Total</th>
                <th>Anulada</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= $order->get('id') ?></td>
                    <td><?= $order->get('dateOrder') ?></td>
                    <td><?= $order->get('idTable') ?></td>
                    <td><?= $order->get('total') ?></td>
                    <td><?= $order->get('isCancelled') ? 'Sí' : 'No' ?></td>
                    <td>
                        <?php if (!$order->get('isCancelled')): ?>
                            <a href="actions/cancelOrder.php?id=<?= $order->get('id') ?>">Anular</a>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="../index.php">Volver al inicio</a>
</body>
</html> 