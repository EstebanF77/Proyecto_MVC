<?php
namespace App\model\entities\Mcategories;

use App\model\drivers\conexDB;
use App\model\Model;


class Categories extends Model{
    protected $id = null;
    protected $nombre = '';


    public function all() {
        $conexDB = new conexDB();
        $sql = "SELECT * FROM personas";
        $res = $conexDB->exeSQL($sql);
        $personas = [];

        if ($res && $res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                $persona = new Personal();
                $persona->set('id', $row['id']);
                $persona->set('nombre', $row['nombre']);
                array_push($personas, $persona);
            }
        }

        $conexDB->close();
        return $personas;
    }

    public function save() {
        $conexDB = new ConexDB();
        $sql = "INSERT INTO personas (nombre, email, edad) VALUES ('" .
               $this->nombre . "','" . $this->email . "'," . $this->edad . ")";
        $res = $conexDB->exeSQL($sql);
        $conexDB->close();
        return $res;
    }

    public function update() {
        // Implementar si es necesario
    }

    public function delete() {
        // Implementar si es necesario
    }
}
