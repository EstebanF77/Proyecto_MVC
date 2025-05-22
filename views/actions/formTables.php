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
    <title><?= $id ? 'Modificar Mesa' : 'Nueva Mesa' ?></title>
</head>
<body>
    <h1><?= $id ? 'Modificar Mesa' : 'Nueva Mesa' ?></h1>
    
    <form action="registrerTables.php" method="POST">
        <?php if ($id): ?>
            <input type="hidden" name="id" value="<?= $id ?>">
        <?php endif; ?>
        
        <div>
            <label for="name">Nombre de la Mesa:</label>
            <input type="text" id="name" name="name" maxlength="10" value="<?= $table ? $table->get('name') : '' ?>" required>
        </div>
        
        <button type="submit"><?= $id ? 'Actualizar' : 'Crear' ?></button>
    </form>
    
    <a href="../listTables.php">Volver</a>
</body>
</html>
