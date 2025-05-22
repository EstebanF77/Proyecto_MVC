<?php
include '../models/drivers/conexDB.php';
include '../models/entities/model.php';
include '../models/entities/order.php';
include '../models/entities/table.php';
include '../models/entities/orderDetail.php';
include '../controller/OrderController.php';
include '../controller/OrderDetailController.php';
include '../controller/TableController.php';

use App\controller\OrderController;
use App\controller\OrderDetailController;

$tableController = new TableController();
$tables = $tableController->getAll();

$tableMap = [];
foreach ($tables as $t) {
    $tableMap[$t->get('id')] = $t->get('name');
}

$orderId = $_GET['id'] ?? null;

if (!$orderId) {
    echo "ID de orden no proporcionado.";
    exit;
}

$orderController = new OrderController();
$detailController = new OrderDetailController();

$orders = $orderController->getAll();

$order = null;
foreach ($orders as $o) {
    if ($o->get('id') == $orderId) {
        $order = $o;
        break;
    }
}

if (!$order) {
    echo "Orden no encontrada.";
    exit;
}

$details = $detailController->getByOrderId($orderId);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de la Orden</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Detalles de la Orden</h1>
        
        <div class="form-container">
            <div class="order-info">
                <p><strong>Fecha:</strong> <?= $order->get('dateOrder') ?></p>
                <p><strong>ID Mesa:</strong> <?= $tableMap[$order->get('idTable')] ?? 'Mesa desconocida' ?></p>
                <p><strong>Estado:</strong> 
                    <span class="badge <?= $order->get('isCancelled') ? 'badge-danger' : 'badge-success' ?>">
                        <?= $order->get('isCancelled') ? 'Anulada' : 'Activa' ?>
                    </span>
                </p>
            </div>

            <h2>Platos</h2>
            <table>
                <thead>
                    <tr>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Precio unitario</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($details as $item): ?>
                        <tr>
                            <td><?= $item->get('description') ?></td>
                            <td><?= $item->get('quantity') ?></td>
                            <td class="price">$<?= number_format($item->get('price'), 2) ?></td>
                            <td class="price">$<?= number_format($item->get('quantity') * $item->get('price'), 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="total-section">
                <h3>Total: <span class="price">$<?= number_format($order->get('total'), 2) ?></span></h3>
            </div>

            <div class="button-group">
                <a href="listOrders.php" class="btn btn-secondary">Volver a la lista</a>
            </div>
        </div>
    </div>
</body>
</html>
