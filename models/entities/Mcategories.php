<?php
namespace App\models\entities;


use App\models\drivers\conexDB;


class Categories extends Model{
    protected $id = null;
    protected $nombre = '';


    public function all() {
        $conexDB = new conexDB();
        $sql = "select * from categorias";
        $res = $conexDB->exeSQL($sql);
        $personas = [];

        if ($res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                $categoria = new Categories();
                $categoria->set('id', $row['id']);
                $categoria->set('nombre', $row['nombre']);
                array_push($categorias, $categoria);
            }
        }

        $conexDB->close();
        return $personas;
    }

    public function save() {
        $conexDB = new ConexDB();
        $sql = "INSERT INTO categoria (nombre) VALUES ('" .
        $this->nombre .")";
        $res = $conexDB->exeSQL($sql);
        $conexDB->close();
        return $res;
    }

    public function update() {
        $conexDb = new ConexDB();
        $sql = "update personas set ";
        $sql .= "nombre='" . $this->nombre . "',";
        $sql .= " where id=" . $this->id;
        $res = $conexDb->exeSQL($sql);
        $conexDb->close();
        return $res;
    }

    public function delete() {
        $conexDb = new ConexDB();
        $sql = "delete from categories where id=" . $this->id;
        $res = $conexDb->exeSQL($sql);
        $conexDb->close();
        return $res;
    }

    public function find(){
        $conexDb = new ConexDB();
        $sql = "select * from personas where id=" . $this->id;
        $res = $conexDb->exeSQL($sql);
        $categories = null;
        if($res->num_rows>0){
            while($row = $res->fetch_assoc()){
                $categories = new Categories();
                $categories->set('id', $row['id']);
                $categories->set('nombre', $row['nombre']);
                break;
            }
        }
        $conexDb->close();      
        return $categories;        
    }
}
