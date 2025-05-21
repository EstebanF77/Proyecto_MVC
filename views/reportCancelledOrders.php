<?php
include '../models/drivers/conexDB.php';
include '../models/entities/model.php';
include '../models/entities/order.php';
include '../controller/OrderController.php';

use App\controller\OrderController;

$controller = new OrderController();

$startDate = $_GET['start'] ?? null;
$endDate = $_GET['end'] ?? null;

$orders = [];
$total = 0;

if ($startDate && $endDate) {
    $orders = $controller->getCancelledOrdersBetween($startDate, $endDate);
    $total = $controller->getCancelledTotalBetween($startDate, $endDate);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Órdenes Anuladas</title>
</head>
<body>
    <h1>Reporte de Órdenes Anuladas</h1>

    <form method="get" action="">
        <label for="start">Fecha inicio:</label>
        <input type="date" name="start" id="start" value="<?= $startDate ?>" required>

        <label for="end">Fecha fin:</label>
        <input type="date" name="end" id="end" value="<?= $endDate ?>" required>

        <button type="submit">Filtrar</button>
    </form>

    <?php if ($startDate && $endDate): ?>
        <h2>Órdenes anuladas entre <?= $startDate ?> y <?= $endDate ?></h2>

        <table border="1" cellpadding="6">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>ID Mesa</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= $order->get('id') ?></td>
                        <td><?= $order->get('dateOrder') ?></td>
                        <td><?= $order->get('idTable') ?></td>
                        <td>$<?= number_format($order->get('total'), 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3>Total de órdenes anuladas: $<?= number_format($total, 2) ?></h3>
    <?php endif; ?>
     <a href="../index.php" class="btn btn-secondary">Volver al inicio</a>
</body>
</html>
