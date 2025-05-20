<?php
require_once '../../models/entities/table.php';
require_once '../../models/entities/dish.php';

use App\models\entities\Table;
use App\models\entities\Dish;

$tables = (new Table())->all();
$dishes = (new Dish())->all();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva Orden</title>
    <script>
        function addRow() {
            const table = document.getElementById('orderDetails');
            const row = table.insertRow();
            const dishSelect = document.getElementById('dishTemplate').cloneNode(true);
            dishSelect.name = 'idDish[]';
            dishSelect.style.display = '';
            row.insertCell(0).appendChild(dishSelect);
            row.insertCell(1).innerHTML = '<input type="number" name="quantity[]" min="1" value="1" onchange="updatePrice(this)">';
            row.insertCell(2).innerHTML = '<input type="text" name="price[]" readonly>';
            row.insertCell(3).innerHTML = '<button type="button" onclick="removeRow(this)">Eliminar</button>';
        }
        function removeRow(btn) {
            btn.parentNode.parentNode.remove();
        }
        function updatePrice(input) {
            const row = input.parentNode.parentNode;
            const dishSelect = row.cells[0].querySelector('select');
            const price = dishSelect.options[dishSelect.selectedIndex].getAttribute('data-price');
            row.cells[2].querySelector('input').value = price;
            updateTotal();
        }
        function updateTotal() {
            let total = 0;
            const table = document.getElementById('orderDetails');
            for (let i = 1; i < table.rows.length; i++) {
                const row = table.rows[i];
                const qty = parseInt(row.cells[1].querySelector('input').value) || 0;
                const price = parseFloat(row.cells[2].querySelector('input').value) || 0;
                total += qty * price;
            }
            document.getElementById('total').value = total.toFixed(2);
        }
    </script>
</head>
<body>
    <h1>Registrar Nueva Orden</h1>
    <form action="registrerOrders.php" method="POST" onsubmit="updateTotal()">
        <label>Fecha:</label>
        <input type="datetime-local" name="dateOrder" required><br>
        <label>Mesa:</label>
        <select name="idTable" required>
            <?php foreach ($tables as $table): ?>
                <option value="<?= $table->get('id') ?>"><?= $table->get('name') ?></option>
            <?php endforeach; ?>
        </select><br>
        <label>Total:</label>
        <input type="text" id="total" name="total" readonly><br>
        <h3>Detalle de la Orden</h3>
        <table id="orderDetails" border="1">
            <tr>
                <th>Plato</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Acción</th>
            </tr>
        </table>
        <button type="button" onclick="addRow()">Agregar Plato</button><br><br>
        <button type="submit">Registrar Orden</button>
    </form>
    <select id="dishTemplate" style="display:none;">
        <?php foreach ($dishes as $dish): ?>
            <option value="<?= $dish->get('id') ?>" data-price="<?= $dish->get('price') ?>">
                <?= $dish->get('description') ?> (<?= $dish->get('price') ?>)
            </option>
        <?php endforeach; ?>
    </select>
    <script>
        // Inicializa una fila al cargar
        window.onload = function() { addRow(); }
        document.getElementById('orderDetails').addEventListener('change', updateTotal);
    </script>
    <a href="../listOrders.php">Volver</a>
</body>
</html> 