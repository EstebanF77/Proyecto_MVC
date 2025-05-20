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
    <title>Categorias</title>
</head>

<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Categorías</h1>
            <a href="index.php?view=formCategories" class="btn btn-primary">Nueva Categoría</a>
        </div>

        <div class="mb-3">
            <form class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Buscar por nombre" required>
                <button type="submit" class="btn btn-outline-primary">Buscar</button>
            </form>
        </div>

        <?php if (empty($categories)): ?>
            <div class="alert alert-info">
                No hay categorías registradas.
            </div>
        <?php else: ?>
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
                            echo '  <td>' . htmlspecialchars($category->get('id')) . '</td>';
                            echo '  <td>' . htmlspecialchars($category->get('nombre')) . '</td>';
                            echo '  <td>';
                            echo '      <a href="index.php?view=formCategories&id=' . $category->get('id') . '" class="btn btn-sm btn-warning">Editar</a> ';
                            echo '      <a href="index.php?action=removeCategorie&id=' . $category->get('id') . '" class="btn btn-sm btn-danger" onclick="return confirm(\'¿Está seguro de eliminar esta categoría?\')">Eliminar</a>';
                            echo '  </td>';
                            echo '</tr>';


                            echo '<tr>';
                            echo '  <td>' . $category->get('id') . '</td>';
                            echo '  <td>' . $category->get('nombre') . '</td>';
             
                            echo '  <td>';
                            echo '      <a href="form_person.php?id=' . $person->get('id') . '">Modificar</a>';
                            echo '      <a href="actions/deletePerson.php?id=' . $person->get('id') . '">';
                            echo '          <img src="../resources/delete.svg" alt="Borrar registro">';
                            echo '      </a>';
                            echo '  </td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>