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
    <title>Registrar Nueva Orden</title>
</head>
<body>
    <h1>Registrar Nueva Orden</h1>

    <form method="POST" action="">
        <input type="hidden" name="row_count" value="<?= $row_count ?>">

        <label>Fecha:</label>
        <input type="datetime-local" name="dateOrder" required value="<?= htmlspecialchars($saved_values['dateOrder']) ?>"><br><br>

        <label>Mesa:</label>
        <select name="idTable" required>
            <option value="">Seleccione una mesa</option>
            <?php foreach ($tables as $table): ?>
                <option value="<?= $table->get('id') ?>" <?= $saved_values['idTable'] == $table->get('id') ? 'selected' : '' ?>>
                    <?= $table->get('name') ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Total:</label>
        <input type="text" name="total" value="<?= number_format($total, 2) ?>" readonly><br><br>

        <h3>Detalle de la Orden</h3>
        <table border="1">
            <tr>
                <th>Plato</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
            </tr>
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
        </table><br>

        <button type="submit" name="add_row">Agregar Plato</button>
        <button type="submit" name="submit_order">Registrar Orden</button>
    </form>

    <br><a href="../listOrders.php">Volver</a>
</body>
</html>
