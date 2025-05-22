<?php
require_once '../../models/entities/table.php';
require_once '../../models/entities/dish.php';

use App\models\entities\Table;
use App\models\entities\Dish;

$tables = (new Table())->all();
$dishes = (new Dish())->all();

$row_count = 1;
$saved_values = [
    'dateOrder' => '',
    'idTable' => '',
    'idDish' => [],
    'quantity' => [],
    'price' => []
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $row_count = isset($_POST['row_count']) ? (int)$_POST['row_count'] : 1;
    $saved_values = [
        'dateOrder' => $_POST['dateOrder'] ?? '',
        'idTable' => $_POST['idTable'] ?? '',
        'idDish' => $_POST['idDish'] ?? [],
        'quantity' => $_POST['quantity'] ?? [],
        'price' => $_POST['price'] ?? []
    ];

    if (isset($_POST['add_row'])) {
        $row_count++;
    } elseif (isset($_POST['submit_order'])) {
        header('Location: registrerOrders.php');
        exit;
    }
}

// Calcular total
$total = 0;
if (!empty($saved_values['idDish']) && !empty($saved_values['quantity'])) {
    foreach ($saved_values['idDish'] as $index => $dishId) {
        foreach ($dishes as $dish) {
            if ($dish->get('id') == $dishId) {
                $quantity = isset($saved_values['quantity'][$index]) ? (int)$saved_values['quantity'][$index] : 0;
                $total += $dish->get('price') * $quantity;
                break;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Orden</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Registrar Nueva Orden</h1>

        <div class="form-container">
            <form method="POST">
                <input type="hidden" name="row_count" value="<?= $row_count ?>">

                <div>
                    <label>Fecha:</label>
                    <input type="datetime-local" name="dateOrder" value="<?= htmlspecialchars($saved_values['dateOrder']) ?>" required>
                </div>
                
                <div>
                    <label>Mesa:</label>
                    <select name="idTable" required>
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
                    <tr>
                        <th>Plato</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                    </tr>
                    <?php for ($i = 0; $i < $row_count; $i++): ?>
                    <tr>
                        <td>
                            <select name="idDish[]" required>
                                <?php foreach ($dishes as $dish): ?>
                                    <option value="<?= $dish->get('id') ?>" 
                                        <?= isset($saved_values['idDish'][$i]) && $saved_values['idDish'][$i] == $dish->get('id') ? 'selected' : '' ?>>
                                        <?= $dish->get('description') ?> (<?= $dish->get('price') ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <input type="number" name="quantity[]" min="1" value="<?= $saved_values['quantity'][$i] ?? 1 ?>" required>
                        </td>
                        <td>
                            <input type="text" name="price[]" value="<?= $saved_values['price'][$i] ?? $dishes[0]->get('price') ?>" readonly>
                        </td>
                    </tr>
                    <?php endfor; ?>
                </table>

                <div class="button-group">
                    <button type="submit" name="add_row" class="btn btn-primary">Agregar Plato</button>
                    <button type="submit" name="submit_order" class="btn btn-success">Registrar Orden</button>
                    <a href="../listOrders.php" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
