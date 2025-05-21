<?php
namespace App\models\entities;

require_once __DIR__ . '/model.php';
require_once __DIR__ . '/../drivers/conexDB.php';

use App\models\drivers\ConexDB;

class OrderDetail extends Model {
    protected $id = null;
    protected $quantity = 0;
    protected $price = 0;
    protected $idOrder = null;
    protected $idDish = null;

    // Permite guardar un nuevo detalle de orden
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

    // No necesitas actualizar un detalle de orden
    public function update()
    {
        return false;
    }

    // No se permite eliminar directamente detalles
    public function delete()
    {
        return false;
    }

    // Método para obtener todos los detalles de una orden específica
    public function all()
    {
        // No tiene sentido retornar todos los detalles de todas las órdenes
        return [];
    }

    // Devuelve los detalles de una orden específica
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
                $detail->set('description', $row['description']); // valor extra útil para mostrar
                $details[] = $detail;
            }
        }

        $conexDb->close();
        return $details;
    }
    
} 
