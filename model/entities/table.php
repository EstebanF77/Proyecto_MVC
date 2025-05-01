<?php
namespace App\model\entities;

use App\model\drivers\conexDB;
use App\model\Model;

class Table extends Model{

    protected $id =  null;
    protected $name = ''; 

    public function all(){ // encargada de ir a la base de datos para seleccionar todos los registros de la base de datos
        $conexDB = new ConexDB();
        $sql = "select * from restaurant_tables";
        $res = $conexDB-> exeSQL($sql); //se pasa la consulta a la base de datos 
        $Tables = []; //se estructura la informacion que entra a de la base de datos

        if ($res->num_rows>0){
            while($row = $res->fetch_assoc()){
                $table = new Table();
                $table->set('id',$row['id']);
                $table->set('name',$row['name']);
                array_push($tables,$table); //cocatena elementos a la linea

            }
        }
        $conexDB->close();
        return $tables;
        
    }

    public function save(){
        $conexDB= new ConexDB();
        $sql = "insert into restaurant_tables (name) values ";
        $sql .= "('" . $this->name . ")";
        $res = $conexDB->exeSQL($sql);
        $conexDB->close();
        return $res;
    }
    public function update()
    {
        $conexDb = new ConexDB();
        $sql = "update restaurant_tables set ";
        $sql .= "nane='" . $this->name . "',";
        $sql .= " where id=" . $this->id;
        $res = $conexDb->exeSQL($sql);
        $conexDb->close();
        return $res;
    }
    public function delete(){

        $conexDb = new ConexDB();
        $sql = "delete from restaurant_tables where id=".$this->id;
        $res = $conexDb->exeSQL($sql);
        $conexDb->close();
        return $res;

    }

    /*
    public function find(){
        $conexDb = new ConexDB();
        $sql = "select * from personas where id=".$this->id;
        $res = $conexDb->exeSQL($sql);
        $persona = null;
        if($res->num_rows>0){
            while($row = $res->fetch_assoc()){
                $persona = new Table();
                $persona->set('id',$row['id']);
                $persona->set('nombre',$row['nombre']);
                break;
            }
        }
        $conexDb->close();
        return $persona;
    }

    public function buscarPorNombre($nombre) {
        $conexDb = new ConexDB();
        $nombre = $conexDb->getConexion()->real_escape_string($nombre); 
        $sql = "SELECT * FROM personas WHERE nombre LIKE '%$nombre%'";
        $res = $conexDb->exeSQL($sql);
    
        $personas = [];
    
        if ($res && $res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                $persona = new Table();
                $persona->set('id', $row['id']);
                $persona->set('nombre', $row['nombre']);
                $personas[] = $persona;
            }
        }

    
        $conexDb->close();
        return $personas;,,
    }
    */

}