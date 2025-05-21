<?php
namespace App\models\entities;

use App\models\drivers\ConexDB;

class OrderDetail extends Model {
    protected $id = null;
    protected $quantity = 0;
    protected $price = 0;
    protected $idOrder = null;
    protected $idDish = null;

    public function save() {
        $conexDB = new ConexDB();
        $sql = "INSERT INTO order_details (quantity, price, idOrder, idDish) VALUES (\n            {$this->quantity}, {$this->price}, {$this->idOrder}, {$this->idDish}\n        )";
        $res = $conexDB->exeSQL($sql);
        $conexDB->close();
        return $res;
    }

    public function all() {
        // No se requiere listar detalles de orden de forma independiente
        return [];
    }

    public function update() {
        // No se permite actualizar detalles de orden
        return false;
    }

    public function delete() {
        // No se permite eliminar detalles de orden
        return false;
    }
    
} 