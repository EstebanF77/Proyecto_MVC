<?php
namespace App\models\entities;


use App\models\drivers\conexDB; 

class Dish extends Model
{
    private $id;
    private $description;
    private $price;
    private $idCategory;

    public function all()
    {
        $conexDb = new ConexDB();
        $sql = "SELECT * FROM dishes";
        $res = $conexDb->exeSQL($sql);
        $dishes = [];

        if ($res && $res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                $dish = new Dish();
                $dish->set('id', $row['id']);
                $dish->set('description', $row['description']);
                $dish->set('price', $row['price']);
                $dish->set('idCategory', $row['idCategory']);
                array_push($dishes, $dish);
            }
        }

        $conexDb->close();
        return $dishes;
    }

    public function save()
    {
        $conexDb = new ConexDB();
        $sql = "INSERT INTO dishes (description, price, idCategory) VALUES ";
        $sql .= "('" . $this->description . "', " . $this->price . ", " . $this->idCategory . ")";
        $res = $conexDb->exeSQL($sql);
        $conexDb->close();
        return $res;
    }

    public function update()
    {
        $conexDb = new ConexDB();
        $sql = "UPDATE dishes SET ";
        $sql .= "description = '" . $this->description . "', ";
        $sql .= "price = " . $this->price . " ";
        $sql .= "WHERE id = " . $this->id;
        $res = $conexDb->exeSQL($sql);
        $conexDb->close();
        return $res;
    }

    public function delete()
    {
        $conexDb = new ConexDB();
        $sql = "DELETE FROM dishes WHERE id = " . $this->id;
        $res = $conexDb->exeSQL($sql);
        $conexDb->close();
        return $res;
    }
}
