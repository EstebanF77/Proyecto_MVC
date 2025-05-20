<?php
namespace App\models\entities;

require_once __DIR__ . '/model.php';

require_once __DIR__ . '/../drivers/conexDB.php';

use App\models\drivers\ConexDB;


class Table extends Model{

    protected $id =  null;
    protected $name = ''; 

    public function all(){ // encargada de ir a la base de datos para seleccionar todos los registros de la base de datos
        $conexDB = new ConexDB();
        $sql = "select * from restaurant_tables";
        $res = $conexDB-> exeSQL($sql); //se pasa la consulta a la base de datos 
        $tables = []; // Inicializamos el array

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

    public function find() {
        $conexDB = new ConexDB();
        $sql = "select * from restaurant_tables where id = " . $this->id;
        $res = $conexDB->exeSQL($sql);
        $table = null;

        if ($res->num_rows > 0) {
            $row = $res->fetch_assoc();
            $table = new Table();
            $table->set('id', $row['id']);
            $table->set('name', $row['name']);
        }
        $conexDB->close();
        return $table;
    }

    public function save(){
        $conexDB= new ConexDB();
        $sql = "insert into restaurant_tables (name) values ";
        $sql .= "('" . $this->name . "')";
        $res = $conexDB->exeSQL($sql);
        $conexDB->close();
        return $res;
    }
    public function update()
    {
        $conexDB = new ConexDB();
        $sql = "update restaurant_tables set ";
        $sql .= "name='" . $this->name . "'";
        $sql .= " where id=" . $this->id;
        $res = $conexDB->exeSQL($sql);
        $conexDB->close();
        return $res;
    }
    public function delete(){
        $conexDB = new ConexDB();
        
        // Primero verificar si la mesa está en uso
        $checkSql = "SELECT COUNT(*) as count FROM orders WHERE idTable = " . $this->id;
        $checkRes = $conexDB->exeSQL($checkSql);
        $row = $checkRes->fetch_assoc();
        
        if ($row['count'] > 0) {
            $conexDB->close();
            return 'in_use';
        }
        
        // Si no está en uso, proceder con la eliminación
        $sql = "delete from restaurant_tables where id=" . $this->id;
        $res = $conexDB->exeSQL($sql);
        $conexDB->close();
        
        return $res ? 'yes' : 'error';
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
        return $personas;
    }
    */

}