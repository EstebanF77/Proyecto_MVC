<?php
include '../models/drivers/conexDB.php';
include '../models/entities/model.php';
include '../models/entities/order.php';
include '../models/entities/table.php';
include '../controller/OrderController.php';
include '../controller/TableController.php';

use App\controller\OrderController;

$controller = new OrderController();
$tableController = new TableController();
$tables = $tableController->getAll();

$tableMap = [];
foreach ($tables as $t) {
    $tableMap[$t->get('id')] = $t->get('name');
}

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Órdenes</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Reporte de Órdenes</h1>
        </div>

        <form method="get" action="">
            <label for="start">Fecha inicio:</label>
            <input type="date" name="start" id="start" value="<?= $startDate ?>" required>

            <label for="end">Fecha fin:</label>
            <input type="date" name="end" id="end" value="<?= $endDate ?>" required>

            <button type="submit">Filtrar</button>
        </form>

        <?php if ($startDate && $endDate): ?>
            <h2>Órdenes no anuladas entre <?= $startDate ?> y <?= $endDate ?></h2>

            <table>
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
                            <td><?= $tableMap[$order->get('idTable')] ?? 'Mesa desconocida' ?></td>
                            <td>$<?= number_format($order->get('total'), 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <h3>Total recaudado: $<?= number_format($total, 2) ?></h3>

            <h2>Ranking de Platos Más Vendidos</h2>
            <table>
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
        <a href="reportCancelledOrders.php" class="btn btn-secondary">Reporte de Órdenes Anuladas</a>
    </div>
</body>
</html>
