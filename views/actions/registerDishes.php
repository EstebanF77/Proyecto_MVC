<?php
include '../../models/drivers/conexDB.php';
include '../../models/entities/model.php';
include '../../models/entities/dish.php';
include '../../controller/DishesController.php';

use app\controller\DishesController;

$controller = new DishesController();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header('Location: ../formDishes.php');
    exit;
}

$id = $_POST['id'] ?? null;

$res = empty($id)
    ? $controller->saveNewDish($_POST)
    : $controller->updateDish($_POST);
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
    <a href="../listDishes.php">Volver</a>
</body>
</html>
