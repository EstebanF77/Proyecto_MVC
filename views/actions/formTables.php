<?php
require_once '../../models/drivers/conexDB.php';
require_once '../../models/entities/model.php';
require_once '../../models/entities/table.php';
require_once '../../controller/TableController.php';

use App\models\entities\Table;

$controller = new TableController();
$id = $_GET['id'] ?? null;
$table = null;

if ($id) {
    $table = $controller->find($id);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $id ? 'Modificar Mesa' : 'Nueva Mesa' ?></title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <h1><?= $id ? 'Modificar Mesa' : 'Nueva Mesa' ?></h1>
        
        <div class="form-container">
            <form action="registrerTables.php" method="POST">
                <?php if ($id): ?>
                    <input type="hidden" name="id" value="<?= $id ?>">
                <?php endif; ?>
                
                <div>
                    <label for="name">Nombre de la Mesa:</label>
                    <input type="text" id="name" name="name" maxlength="10" 
                           value="<?= $table ? $table->get('name') : '' ?>" required>
                </div>
                
                <div class="button-group">
                    <button type="submit" class="btn btn-primary">
                        <?= $id ? 'Actualizar' : 'Crear' ?>
                    </button>
                    <a href="../listTables.php" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
