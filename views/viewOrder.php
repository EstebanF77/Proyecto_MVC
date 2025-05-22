<?php
include '../models/drivers/conexDB.php';
include '../models/entities/model.php';
include '../models/entities/order.php';
include '../models/entities/orderDetail.php';
include '../controller/OrderController.php';
include '../controller/OrderDetailController.php';

use App\controller\OrderController;
use App\controller\OrderDetailController;

$orderId = $_GET['id'] ?? null;

if (!$orderId) {
    echo "ID de orden no proporcionado.";
    exit;
}

$orderController = new OrderController();
$detailController = new OrderDetailController();

$orders = $orderController->getAll();

// Obtener la orden por ID (puedes mejorar esto con un método `getById()`)
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
    <title>Detalle de la Orden</title>
</head>
<body>
    <h1>Detalles de la Orden</h1>
    <p><strong>Fecha:</strong> <?= $order->get('dateOrder') ?></p>
    <p><strong>ID Mesa:</strong> <?= $order->get('idTable') ?></p>
    <p><strong>Estado:</strong> <?= $order->get('isCancelled') ? 'Anulada' : 'Activa' ?></p>

    <h2>Platos</h2>
    <table border="1" cellpadding="6">
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
                    <td>$<?= number_format($item->get('price'), 2) ?></td>
                    <td>$<?= number_format($item->get('quantity') * $item->get('price'), 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Total: $<?= number_format($order->get('total'), 2) ?></h3>

    <a href="listOrders.php">Volver a la lista</a>
</body>
</html>
