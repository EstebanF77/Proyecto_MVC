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
$ranking = [];

if ($startDate && $endDate) {
    $orders = $controller->getOrdersBetween($startDate, $endDate);
    $total = $controller->getTotalBetween($startDate, $endDate);
    $ranking = $controller->getRankingBetween($startDate, $endDate);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Órdenes</title>
</head>
<body>
    <h1>Reporte de Órdenes</h1>

    <!-- Formulario de filtro -->
    <form method="get" action="">
        <label for="start">Fecha inicio:</label>
        <input type="date" name="start" id="start" value="<?= $startDate ?>" required>

        <label for="end">Fecha fin:</label>
        <input type="date" name="end" id="end" value="<?= $endDate ?>" required>

        <button type="submit">Filtrar</button>
    </form>

    <?php if ($startDate && $endDate): ?>
        <h2>Órdenes no anuladas entre <?= $startDate ?> y <?= $endDate ?></h2>

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

        <h3>Total recaudado: $<?= number_format($total, 2) ?></h3>

        <h2>Ranking de Platos Más Vendidos</h2>
        <table border="1" cellpadding="6">
            <thead>
                <tr>
                    <th>Plato</th>
                    <th>Cantidad Vendida</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ranking as $item): ?>
                    <tr>
                        <td><?= $item['description'] ?></td>
                        <td><?= $item['cantidad'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
      <a href="../index.php" class="btn btn-secondary">Volver al inicio</a>
</body>
</html>
