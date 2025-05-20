<?php
namespace App\models\entities;

require_once __DIR__ . '/model.php';

require_once __DIR__ . '/../drivers/conexDB.php';

use App\models\drivers\ConexDB;

class Order extends Model {
    protected $id = null;
    protected $dateOrder = '';
    protected $total = 0;
    protected $idTable = null;
    protected $isCancelled = 0;

    public function save() {
        $conexDB = new ConexDB();
        $sql = "INSERT INTO orders (dateOrder, total, idTable, isCancelled) VALUES (\n            '{$this->dateOrder}', {$this->total}, {$this->idTable}, {$this->isCancelled}\n        )";
        $res = $conexDB->exeSQL($sql);
        $orderId = $conexDB->getConexion()->insert_id;
        $conexDB->close();
        return $orderId;
    }

    public function cancel() {
        $conexDB = new ConexDB();
        $sql = "UPDATE orders SET isCancelled=1 WHERE id={$this->id}";
        $res = $conexDB->exeSQL($sql);
        $conexDB->close();
        return $res;
    }

    public function all() {
        $conexDB = new ConexDB();
        $sql = "SELECT * FROM orders";
        $res = $conexDB->exeSQL($sql);
        $orders = [];
        if ($res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                $order = new Order();
                $order->set('id', $row['id']);
                $order->set('dateOrder', $row['dateOrder']);
                $order->set('total', $row['total']);
                $order->set('idTable', $row['idTable']);
                $order->set('isCancelled', $row['isCancelled']);
                $orders[] = $order;
            }
        }
        $conexDB->close();
        return $orders;
    }

    public function update() {
        // No se permite actualizar órdenes
        return false;
    }

    public function delete() {
        // No se permite eliminar órdenes
        return false;
    }
} 