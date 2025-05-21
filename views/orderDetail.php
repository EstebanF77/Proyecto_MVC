<?php
include '../models/drivers/conexDB.php';
include '../models/entities/model.php';
include '../models/entities/order.php';
include '../controller/OrderController.php';

use App\controller\OrderController;

$orderController = new OrderController();
$id = $_GET['id'] ?? null;

if (!$id) {
    echo "ID de orden no proporcionado.";
    exit;
}

$order = $orderController->getById($id);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle de la Orden</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<div class="container">
    <h1>Factura / Detalle de Orden</h1>

    <p><strong>ID Orden:</strong> <?= $order->get('id') ?></p>
    <p><strong>Fecha:</strong> <?= $order->get('dateOrder') ?></p>
    <p><strong>Mesa:</strong> <?= $order->get('idTable') ?></p>
    <p><strong>Total:</strong> $<?= number_format($order->get('total'), 2) ?></p>
    <p><strong>Anulada:</strong> <?= $order->get('isCancelled') ? 'Sí' : 'No' ?></p>

    <h3>Platos:</h3>
    <table>
        <thead>
            <tr>
                <th>Descripción</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($order->details as $item): ?>
                <tr>
                    <td><?= $item['description'] ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td>$<?= number_format($item['price'], 2) ?></td>
                    <td>$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <br>
    <a href="listOrders.php" class="btn btn-secondary">Volver</a>
</div>
</body>
</html>
