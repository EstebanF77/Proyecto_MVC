<?php

$controller = new DishesController();
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header('location: ../personas.php');
}

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header('location: ../personas.php');
}
$res = empty($_POST['idPerson'])
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
    <a href="../dishes.php">Volver</a>
</body>

</html>