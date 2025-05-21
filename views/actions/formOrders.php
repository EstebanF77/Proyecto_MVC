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
        // Aquí iría el guardado real en la base de datos
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
    <title>Nueva Orden</title>
    <script>
        function updatePrice(select) {
            const row = select.closest('tr');
            const priceInput = row.querySelector('input[name="price[]"]');
            const selectedOption = select.options[select.selectedIndex];
            const price = selectedOption.getAttribute('data-price');
            priceInput.value = price;
            updateTotal();
        }

        function updateTotal() {
            let total = 0;
            const rows = document.querySelectorAll('table tr:not(:first-child)');
            rows.forEach(row => {
                const quantity = parseInt(row.querySelector('input[name="quantity[]"]').value) || 0;
                const price = parseFloat(row.querySelector('input[name="price[]"]').value) || 0;
                total += quantity * price;
            });
            document.querySelector('input[name="total"]').value = total.toFixed(2);
        }
    </script>
</head>
<body>
    <h1>Registrar Nueva Orden</h1>

    <form method="POST">
        <input type="hidden" name="row_count" value="<?= $row_count ?>">

        <label>Fecha:</label>
        <input type="datetime-local" name="dateOrder" value="<?= htmlspecialchars($saved_values['dateOrder']) ?>" required><br>
        
        <label>Mesa:</label>
        <select name="idTable" required>
            <?php foreach ($tables as $table): ?>
                <option value="<?= $table->get('id') ?>" <?= $saved_values['idTable'] == $table->get('id') ? 'selected' : '' ?>>
                    <?= $table->get('name') ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <label>Total:</label>
        <input type="text" name="total" value="<?= number_format($total, 2) ?>" readonly><br>

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
                    <select name="idDish[]" required onchange="updatePrice(this)">
                        <?php foreach ($dishes as $dish): ?>
                            <option value="<?= $dish->get('id') ?>" 
                                data-price="<?= $dish->get('price') ?>"
                                <?= isset($saved_values['idDish'][$i]) && $saved_values['idDish'][$i] == $dish->get('id') ? 'selected' : '' ?>>
                                <?= $dish->get('description') ?> (<?= $dish->get('price') ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td>
                    <input type="number" name="quantity[]" min="1" value="<?= $saved_values['quantity'][$i] ?? 1 ?>" required onchange="updateTotal()">
                </td>
                <td>
                    <input type="text" name="price[]" value="<?= $saved_values['price'][$i] ?? $dishes[0]->get('price') ?>" readonly>
                </td>
            </tr>
            <?php endfor; ?>
        </table>

        <button type="submit" name="add_row">Agregar Plato</button>
        <button type="submit" name="submit_order">Registrar Orden</button>
    </form>

    <a href="../listOrders.php">Volver</a>
</body>
</html>
