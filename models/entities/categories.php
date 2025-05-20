<?php
namespace App\models\entities;

use App\models\drivers\ConexDB;

class Categories extends Model {
    protected $id = null;
    protected $name = '';

    public function all() {
        $conexDB = new ConexDB();
        $sql = "SELECT * FROM categories";
        $res = $conexDB->exeSQL($sql);
        $categories = [];

        if ($res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                $categoria = new Categories();
                $categoria->set('id', $row['id']);
                $categoria->set('name', $row['name']);
                array_push($categories, $categoria);
            }
        }

        $conexDB->close();
        return $categories;
    }

    public function save() {
        $conexDB = new ConexDB();
        $sql = "INSERT INTO categories (name) VALUES ('" . $this->name . "')";
        $res = $conexDB->exeSQL($sql);
        $conexDB->close();
        return $res;
    }

    public function update() {
        $conexDB = new ConexDB();
        $sql = "UPDATE categories SET name='" . $this->name . "' WHERE id=" . $this->id;  
        $res = $conexDB->exeSQL($sql);
        $conexDB->close();
        return $res;
    }

    public function delete() {
        $conexDB = new ConexDB();
        $sql = "DELETE FROM categories WHERE id=" . $this->id;
        $res = $conexDB->exeSQL($sql);
        $conexDB->close();
        return $res;
    }

    public function find(){
        $conexDB = new ConexDB();
        $sql = "SELECT * FROM categories WHERE id=" . $this->id;
        $res = $conexDB->exeSQL($sql);
        $category = null;
        if($res->num_rows > 0){
            while($row = $res->fetch_assoc()){
                $category = new Categories();
                $category->set('id', $row['id']);
                $category->set('name', $row['name']);
                break;
            }
        }
        $conexDB->close();      
        return $category;        
    }
}
