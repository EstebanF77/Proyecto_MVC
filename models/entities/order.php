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
    public $details = [];

    public function save() {
        $conexDB = new ConexDB();
        $sql = "INSERT INTO orders (dateOrder, idTable, total, isCancelled) 
                VALUES ('" . $this->dateOrder . "', " . $this->idTable . ", " . 
                $this->total . ", 0)";
        $res = $conexDB->exeSQL($sql);
        $lastId = $conexDB->getLastId();
        $conexDB->close();
        return $lastId;
    }

    public function getLastId() {
        $conexDB = new ConexDB();
        $lastId = $conexDB->getLastId();
        $conexDB->close();
        return $lastId;
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
    
    public function getOrdersBetweenDates($start, $end)
    {
    $conexDb = new ConexDB();
    $sql = "SELECT * FROM orders 
            WHERE isCancelled = 0 
            AND dateOrder BETWEEN '$start' AND '$end'";
    
    $res = $conexDb->exeSQL($sql);
    $orders = [];

    if ($res && $res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
            $order = new Order();
            $order->set('id', $row['id']);
            $order->set('dateOrder', $row['dateOrder']);
            $order->set('idTable', $row['idTable']);
            $order->set('total', $row['total']);
            $orders[] = $order;
        }
    }

    $conexDb->close();
    return $orders;
    }

    public function getTotalBetweenDates($start, $end)
    {
    $conexDb = new ConexDB();
    $sql = "SELECT SUM(total) AS total FROM orders 
            WHERE isCancelled = 0 
            AND dateOrder BETWEEN '$start' AND '$end'";
    
    $res = $conexDb->exeSQL($sql);
    $total = 0;

    if ($res && $row = $res->fetch_assoc()) {
        $total = $row['total'] ?? 0;
    }

    $conexDb->close();
    return $total;
    }

    public function getMostSoldDishesBetweenDates($start, $end)
{
    $conexDb = new ConexDB();
    $sql = "SELECT d.description, SUM(od.quantity) AS cantidad
            FROM order_details od
            JOIN dishes d ON d.id = od.idDish
            JOIN orders o ON o.id = od.idOrder
            WHERE o.isCancelled = 0 
            AND o.dateOrder BETWEEN '$start' AND '$end'
            GROUP BY od.idDish
            ORDER BY cantidad DESC";

    $res = $conexDb->exeSQL($sql);
    $ranking = [];

    if ($res && $res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
            $ranking[] = [
                'description' => $row['description'],
                'cantidad' => $row['cantidad']
            ];
        }
    }

    $conexDb->close();
    return $ranking;
}
public function getCancelledOrdersBetweenDates($start, $end)
{
    $conexDb = new ConexDB();
    $sql = "SELECT * FROM orders 
            WHERE isCancelled = 1 
            AND dateOrder BETWEEN '$start' AND '$end'";
    
    $res = $conexDb->exeSQL($sql);
    $orders = [];

    if ($res && $res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
            $order = new Order();
            $order->set('id', $row['id']);
            $order->set('dateOrder', $row['dateOrder']);
            $order->set('idTable', $row['idTable']);
            $order->set('total', $row['total']);
            $orders[] = $order;
        }
    }

    $conexDb->close();
    return $orders;
}
public function getCancelledTotalBetweenDates($start, $end)
{
    $conexDb = new ConexDB();
    $sql = "SELECT SUM(total) AS total FROM orders 
            WHERE isCancelled = 1 
            AND dateOrder BETWEEN '$start' AND '$end'";
    
    $res = $conexDb->exeSQL($sql);
    $total = 0;

    if ($res && $row = $res->fetch_assoc()) {
        $total = $row['total'] ?? 0;
    }

    $conexDb->close();
    return $total;
}

public function findWithDetails($id)
{
    $conexDB = new ConexDB();

    // Obtener orden principal
    $sql = "SELECT * FROM orders WHERE id = $id";
    $res = $conexDB->exeSQL($sql);

    if ($res && $res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $this->set('id', $row['id']);
        $this->set('dateOrder', $row['dateOrder']);
        $this->set('total', $row['total']);
        $this->set('idTable', $row['idTable']);
        $this->set('isCancelled', $row['isCancelled']);

        // Obtener detalles de la orden
        $sqlDetails = "SELECT od.quantity, od.price, d.description 
                       FROM order_details od 
                       JOIN dishes d ON d.id = od.idDish 
                       WHERE od.idOrder = $id";

        $resDetails = $conexDB->exeSQL($sqlDetails);
        $details = [];

        if ($resDetails && $resDetails->num_rows > 0) {
            while ($detail = $resDetails->fetch_assoc()) {
                $details[] = $detail;
            }
        }

        $this->details = $details; // propiedad dinámica (no definida en atributos)
    }

    $conexDB->close();
    return $this;
}


    public function find() {
        $conexDB = new ConexDB();
        $sql = "SELECT * FROM orders WHERE id = " . $this->id;
        $res = $conexDB->exeSQL($sql);
        $order = null;
        if ($res->num_rows > 0) {
            $row = $res->fetch_assoc();
            $order = new Order();
            $order->set('id', $row['id']);
            $order->set('dateOrder', $row['dateOrder']);
            $order->set('total', $row['total']);
            $order->set('idTable', $row['idTable']);
            $order->set('isCancelled', $row['isCancelled']);
        }
        $conexDB->close();
        return $order;
    }

} 