<?php
require_once '../../models/drivers/conexDB.php';
require_once '../../models/entities/model.php';
require_once '../../models/entities/table.php';
require_once '../../controller/TableController.php';

use App\models\entities\Table;

$controller = new TableController();
$res = $controller->delete($_GET['id'] ?? null);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Eliminar mesa</title>
</head>

<body>
    <h1>Resultado de la operación</h1>
    <?php
    switch ($res) {
    case 'yes':
        echo '<p>Mesa eliminada correctamente.</p>';
        break;
    case 'in_use':
        echo '<p>No se puede eliminar la mesa porque está en uso en órdenes.</p>';
        break;
    case 'error':
    default:
        echo '<p>No se pudo eliminar la mesa.</p>';
        break;
    }
    ?>
    <br>
    <a href="../listTables.php">Volver</a>
</body>

</html>
