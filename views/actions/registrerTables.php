<?php
require_once '../../models/drivers/conexDB.php';
require_once '../../models/entities/model.php';
require_once '../../models/entities/table.php';
require_once '../../controller/TableController.php';

use App\models\entities\Table;

$controller = new TableController();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header('Location: ../listTables.php');
    exit;
}

$id = $_POST['id'] ?? null;
$name = $_POST['name'] ?? '';

if (empty($id)) {
    $res = $controller->create($name);
} else {
    $res = $controller->update($id, $name);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado operación</title>
</head>
<body>
    <h1>Resultado de la operación</h1>
    <?php if ($res === 'yes'): ?>
        <p>Datos guardados correctamente.</p>
    <?php else: ?>
        <p>No se pudo guardar los datos.</p>
    <?php endif; ?>
    <br>
    <a href="../listTables.php">Volver</a>
</body>
</html>
                