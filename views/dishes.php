<?php

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>registrar plato</title>
</head>
<body>
<form action="actions\registerDishes.php" method="post">

        <div>
            <label for="descriptionDish">descripción del plato</label>
            <input type="text" id="descriptionDish" name="descriptionDish" >
        </div>

        <div>
        <?php
           echo' <label for="categories">categoria</label>';
           echo '<select type="text" id="categories" name="categories">' ;
        foreach ($categories as $category){
                echo ' <option value="'. $category->get('id').'"> hola '.  $category->get('name'). ' </option> ';
            }
          echo '</select>';  
            ?>
          
        </div>

        <div>
            <label for="unitPrice">precio unitario</label>
            <input type="number" id="unitPrice" name="unitPrice" min="0"
            >
        </div>
        <div>
            <button type="submit">Registrar</button>
        </div>
    </form>
</body>
</html>