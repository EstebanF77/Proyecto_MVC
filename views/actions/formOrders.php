<?php
require_once '../../models/entities/table.php';
require_once '../../models/entities/dish.php';

use App\models\entities\Table;
use App\models\entities\Dish;

// Obtener datos
$tables = (new Table())->all();
$dishes = (new Dish())->all();

// Valores guardados y control de filas
$row_count = $_POST['row_count'] ?? 1;
$saved_values = [
    'dateOrder' => $_POST['dateOrder'] ?? '',
    'idTable'   => $_POST['idTable'] ?? '',
    'idDish'    => $_POST['idDish'] ?? [],
    'quantity'  => $_POST['quantity'] ?? [],
    'price'     => []
];

// Calcular precios unitarios y total
$total = 0;
foreach ($saved_values['idDish'] as $i => $dishId) {
    foreach ($dishes as $dish) {
        if ($dish->get('id') == $dishId) {
            $price = $dish->get('price');
            $saved_values['price'][$i] = $price;
            $qty = isset($saved_values['quantity'][$i]) ? (int)$saved_values['quantity'][$i] : 0;
            $total += $price * $qty;
            break;
        }
    }
}

// Si se presionó "Agregar fila"
if (isset($_POST['add_row'])) {
    $row_count++;
}

// Si se presionó "Registrar orden"
if (isset($_POST['submit_order'])) {
    $_POST['price'] = $saved_values['price'];
    $_POST['total'] = $total;
    $query = http_build_query($_POST);
    header("Location: registrerOrders.php?$query");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Nueva Orden</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Registrar Nueva Orden</h1>
        </div>
        <div class="form-container">
            <form method="POST" action="">
                <input type="hidden" name="row_count" value="<?= $row_count ?>">

                <div>
                    <label>Fecha:</label>
                    <input type="datetime-local" name="dateOrder" required value="<?= htmlspecialchars($saved_values['dateOrder']) ?>">
                </div>

                <div>
                    <label>Mesa:</label>
                    <select name="idTable" required>
                        <option value="">Seleccione una mesa</option>
                        <?php foreach ($tables as $table): ?>
                            <option value="<?= $table->get('id') ?>" <?= $saved_values['idTable'] == $table->get('id') ? 'selected' : '' ?>>
                                <?= $table->get('name') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label>Total:</label>
                    <input type="text" name="total" value="<?= number_format($total, 2) ?>" readonly>
                </div>

                <h3>Detalle de la Orden</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Plato</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i = 0; $i < $row_count; $i++): ?>
                            <tr>
                                <td>
                                    <select name="idDish[]" required>
                                        <option value="">Seleccione un plato</option>
                                        <?php foreach ($dishes as $dish): ?>
                                            <option value="<?= $dish->get('id') ?>"
                                                <?= isset($saved_values['idDish'][$i]) && $saved_values['idDish'][$i] == $dish->get('id') ? 'selected' : '' ?>>
                                                <?= $dish->get('description') ?> (<?= number_format($dish->get('price'), 2) ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="quantity[]" min="1" value="<?= $saved_values['quantity'][$i] ?? 1 ?>" required>
                                </td>
                                <td>
                                    <input type="text" name="price[]" value="<?= $saved_values['price'][$i] ?? '' ?>" readonly>
                                </td>
                            </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
                <div class="button-group">
                    <button type="submit" name="add_row" class="btn btn-secondary">Agregar Plato</button>
                    <button type="submit" name="submit_order" class="btn btn-primary">Registrar Orden</button>
                    <a href="../listOrders.php" class="btn btn-secondary">Volver</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
