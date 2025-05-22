<?php
namespace App\models\entities;


use App\models\drivers\ConexDB;


class Table extends Model{

    protected $id =  null;
    protected $name = ''; 

    public function all(){ 
        $conexDB = new ConexDB();
        $sql = "select * from restaurant_tables";
        $res = $conexDB-> exeSQL($sql);  
        $tables = []; 

        if ($res->num_rows>0){
            while($row = $res->fetch_assoc()){
                $table = new Table();
                $table->set('id',$row['id']);
                $table->set('name',$row['name']);
                array_push($tables,$table); 

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
        
        
        $checkSql = "SELECT COUNT(*) as count FROM orders WHERE idTable = " . $this->id;
        $checkRes = $conexDB->exeSQL($checkSql);
        $row = $checkRes->fetch_assoc();
        
        if ($row['count'] > 0) {
            $conexDB->close();
            return 'in_use';
        }
        
        
        $sql = "delete from restaurant_tables where id=" . $this->id;
        $res = $conexDB->exeSQL($sql);
        $conexDB->close();
        
        return $res ? 'yes' : 'error';
    }

    

}