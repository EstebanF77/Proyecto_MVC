<?php
include '../../models/drivers/conexDB.php';
include '../../models/entities/model.php';
include '../../models/entities/categories.php';
include '../../controller/Categoriescontroller.php';

use app\controller\CategoriesController;
$controller = new CategoriesController();


if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header('location: ../categories.php');
}
$res = empty($_POST['idCategorie'])
    ? $controller->saveNewCategorie($_POST)
    : $controller->updateCategorie($_POST);
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
    <a href="../categories.php">Volver</a>
</body>
?>