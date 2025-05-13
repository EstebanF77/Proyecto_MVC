<?php
include '../../models/drivers/conexDB.php';
include '../../models/entities/model.php';
include '../../models/entities/dishes.php';
include '../../controller/dishesController.php';

use app\controller\DihsesController;
$controller = new DihsesController();




if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header('location: ../dishes.php');
}
$res = empty($_POST['idDish'])
    ? $controller->saveNewDish($_POST)
    : $controller->updateDish($_POST);
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado operación</title>
</head>

<body>
    <h1>Resultado de la operación</h1>
    <?php
    if ($res == 'yes') {
        echo '<p>Datos guardados</p>';
    } else {
        echo  '<p>No se pudo guardar los datos</p>';
    }
    ?>
    <br>
    <a href="../formDishes.php">Volver</a>
</body>

</html>