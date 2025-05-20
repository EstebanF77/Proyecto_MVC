<?php
//interface que carga los datos de las categorías
include '../models/drivers/conexDB.php';    
include '../models/entities/model.php';
include '../models/entities/categories.php';
include '../controller/categoriesController.php';

use app\controller\CategoriesController;
use App\models\entities\Categories;

$controller = new CategoriesController();  //objeto del controlador encerrado en un metodo del controlador
$categories = $controller->getAllCategories();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>categorias</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Categorías</h1>
            <a href="actions/formCategories.php" class="btn btn-primary">Nueva Categoría</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($categories as $category) {
                    echo '<tr>';
                    echo '  <td>' . $category->get('name') . '</td>';
                    echo '  <td class="actions">';
                    echo '      <a href="actions/formCategories.php?id=' . $category->get('id') . '" class="btn btn-warning">Editar</a> ';
                    echo '      <a href="actions/deleteCategories.php?id=' . $category->get('id') . '" class="btn btn-danger">Eliminar</a>';
                    echo '  </td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
        <a href="../index.php" class="btn btn-secondary">Volver al inicio</a>
    </div>
</body>

</html>