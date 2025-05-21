<?php
namespace App\models\entities;

require_once __DIR__ . '/model.php';
require_once __DIR__ . '/../drivers/conexDB.php';

use App\models\drivers\ConexDB;

class OrderDetail extends Model {
    protected $id = null;
    protected $idOrder = null;
    protected $idDish = null;
    protected $quantity = 0;
    protected $price = 0;

    public function __construct() {
        // No llamar al constructor del padre ya que Model es una clase abstracta
    }

    public function all() {
        $conexDB = new ConexDB();
        $sql = "SELECT * FROM order_details";
        $res = $conexDB->exeSQL($sql);
        $details = [];
        if ($res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                $detail = new OrderDetail();
                $detail->set('id', $row['id']);
                $detail->set('idOrder', $row['idOrder']);
                $detail->set('idDish', $row['idDish']);
                $detail->set('quantity', $row['quantity']);
                $detail->set('price', $row['price']);
                array_push($details, $detail);
            }
        }
        $conexDB->close();
        return $details;
    }

    public function save() {
        $conexDB = new ConexDB();
        $sql = "INSERT INTO order_details (idOrder, idDish, quantity, price) 
                VALUES (" . $this->idOrder . ", " . $this->idDish . ", " . 
                $this->quantity . ", " . $this->price . ")";
        $res = $conexDB->exeSQL($sql);
        $conexDB->close();
        return $res;
    }

    public function update() {
        $conexDB = new ConexDB();
        $sql = "UPDATE order_details SET 
                idOrder = " . $this->idOrder . ",
                idDish = " . $this->idDish . ",
                quantity = " . $this->quantity . ",
                price = " . $this->price . "
                WHERE id = " . $this->id;
        $res = $conexDB->exeSQL($sql);
        $conexDB->close();
        return $res;
    }

    public function delete() {
        $conexDB = new ConexDB();
        $sql = "DELETE FROM order_details WHERE id = " . $this->id;
        $res = $conexDB->exeSQL($sql);
        $conexDB->close();
        return $res;
    }

    public function findByOrder($orderId) {
        $conexDB = new ConexDB();
        $sql = "SELECT * FROM order_details WHERE idOrder = " . $orderId;
        $res = $conexDB->exeSQL($sql);
        $details = [];
        
        if ($res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                $detail = new OrderDetail();
                $detail->set('id', $row['id']);
                $detail->set('idOrder', $row['idOrder']);
                $detail->set('idDish', $row['idDish']);
                $detail->set('quantity', $row['quantity']);
                $detail->set('price', $row['price']);
                array_push($details, $detail);
            }
        }
        
        $conexDB->close();
        return $details;
    }
} 