<?php
require_once __DIR__ . '/../models/entities/order.php';
require_once __DIR__ . '/../models/entities/order_detail.php';
require_once __DIR__ . '/../models/entities/dish.php';
require_once __DIR__ . '/../models/entities/table.php';

use App\models\entities\Order;
use App\models\entities\OrderDetail;
use App\models\entities\Dish;
use App\models\entities\Table;

class OrderController {
    public function getAll() {
        $order = new Order();
        return $order->all();
    }

    public function create($data, $details) {
        $order = new Order();
        $order->set('dateOrder', $data['dateOrder']);
        $order->set('total', $data['total']);
        $order->set('idTable', $data['idTable']);
        $order->set('isCancelled', 0);
        $orderId = $order->save();

        foreach ($details as $detail) {
            $orderDetail = new OrderDetail();
            $orderDetail->set('quantity', $detail['quantity']);
            $orderDetail->set('price', $detail['price']);
            $orderDetail->set('idOrder', $orderId);
            $orderDetail->set('idDish', $detail['idDish']);
            $orderDetail->save();
        }
        return $orderId;
    }

    public function cancel($id) {
        $order = new Order();
        $order->set('id', $id);
        return $order->cancel();
    }
} 