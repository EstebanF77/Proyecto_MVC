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
</head>

<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Categorías</h1>
            <a href="actions/formCategories.php" class="btn btn-primary">Nueva Categoría</a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($categories as $category) {
                        echo '<tr>';
                        echo '  <td>' . $category->get('id') . '</td>';
                        echo '  <td>' . $category->get('name') . '</td>';
                        echo '  <td>';
                        echo '      <a href="actions/formCategories.php?id=' . $category->get('id') . '" class="btn btn-sm btn-warning">Editar</a> ';
                        echo '      <a href="actions/deleteCategories.php?id=' . $category->get('id') . '" class="btn btn-sm btn-danger" onclick="return confirm(\'¿Está seguro de eliminar esta categoría?\')">Eliminar</a>';
                        echo '  </td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>