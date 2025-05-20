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

$id = $_POST['idCategorie'];
$res = $controller->removeCategorie($id);
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado operación</title>
</head>

<body>
    <h1>Resultado de la operación</h1>
    <?php
    switch($res) {
        case 'yes':
            echo '<p>Categoría eliminada exitosamente</p>';
            break;
        case 'empty':
            echo '<p>La categoría no existe</p>';
            break;
        case 'has_dishes':
            echo '<p>No se puede eliminar la categoría porque tiene platos asociados</p>';
            break;
        default:
            echo '<p>No se pudo eliminar la categoría</p>';
    }
    ?>
    <br>
    <a href="../categories.php">Volver</a>
</body>
</html> 