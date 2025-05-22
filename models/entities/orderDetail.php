<?php
namespace App\models\entities;


use App\models\drivers\ConexDB;

class OrderDetail extends Model {
    protected $id = null;
    protected $quantity = 0;
    protected $price = 0;
    protected $idOrder = null;
    protected $idDish = null;

    
    public function save()
    {
        $conexDb = new ConexDB();
        $sql = "INSERT INTO order_details (quantity, price, idOrder, idDish) VALUES (
                    {$this->quantity},
                    {$this->price},
                    {$this->idOrder},
                    {$this->idDish}
                )";
        $res = $conexDb->exeSQL($sql);
        $conexDb->close();
        return $res;
    }

    
    public function update()
    {
        return false;
    }

   
    public function delete()
    {
        return false;
    }

    
    public function all()
    {
        
        return [];
    }

    
    public function allByOrderId($orderId)
    {
        $conexDb = new ConexDB();
        $sql = "SELECT od.*, d.description 
                FROM order_details od
                JOIN dishes d ON d.id = od.idDish
                WHERE od.idOrder = $orderId";
        
        $res = $conexDb->exeSQL($sql);
        $details = [];

        if ($res && $res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                $detail = new OrderDetail();
                $detail->set('id', $row['id']);
                $detail->set('quantity', $row['quantity']);
                $detail->set('price', $row['price']);
                $detail->set('idOrder', $row['idOrder']);
                $detail->set('idDish', $row['idDish']);
                $detail->set('description', $row['description']); 
                $details[] = $detail;
            }
        }

        $conexDb->close();
        return $details;
    }
    
} 
