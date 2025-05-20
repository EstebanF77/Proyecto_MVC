<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Categoría</title>
</head>
<body>
    <form action="views\actions\registerCategories.php" method="post">
        <div>
            <label for="nameCategory">Nombre de la categoría</label>
            <input type="text" id="nameCategory" name="nameCategory" required>
        </div>

        <div>
            <button type="submit">Registrar</button>
        </div>
    </form>
</body>
</html>