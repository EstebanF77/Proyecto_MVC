<?php
include '../models/drivers/conexDB.php';
include '../models/entities/model.php';
include '../models/entities/order.php';
include '../models/entities/table.php';
include '../controller/OrderController.php';
include '../controller/TableController.php';

use App\controller\OrderController;

$orderController = new OrderController();
$orders = $orderController->getAll();

$tableController = new TableController();
$tables = $tableController->getAll();

$tableMap = [];
foreach ($tables as $t) {
    $tableMap[$t->get('id')] = $t->get('name');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Órdenes</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Órdenes registradas</h1>
            <a href="actions/formOrders.php" class="btn btn-primary">Registrar nueva orden</a>
        </div>

        <table>
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
                        <td><?= $tableMap[$order->get('idTable')] ?? 'Mesa desconocida' ?></td>
                        <td>$<?= number_format($order->get('total'), 2) ?></td>
                        <td>
                            <span class="badge <?= $order->get('isCancelled') ? 'badge-danger' : 'badge-success' ?>">
                                <?= $order->get('isCancelled') ? 'Sí' : 'No' ?>
                            </span>
                        </td>
                        <td>
                             <a href="viewOrder.php?id=<?= $order->get('id') ?>" class="btn btn-primary">Ver detalles</a>
                            <?php if (!$order->get('isCancelled')): ?>
                                <a href="actions/cancelOrder.php?id=<?= $order->get('id') ?>" class="btn btn-danger">Anular</a>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="../index.php" class="btn btn-secondary">Volver al inicio</a>
    </div>
</body>
</html> 