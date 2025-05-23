<?php
namespace app\controller;

require_once __DIR__ . '/../models/entities/order.php';
require_once __DIR__ . '/../models/entities/orderDetail.php';

use App\models\entities\Order;
use App\models\entities\OrderDetail;


class OrderController {
    private $order;
    private $orderDetail;

    public function __construct() {
        $this->order = new Order();
        $this->orderDetail = new OrderDetail();
    }

    public function getAll() {
        return $this->order->all();
    }

    public function create($data, $details) {
        
        $this->order->set('dateOrder', $data['dateOrder']);
        $this->order->set('idTable', $data['idTable']);
        $this->order->set('total', $data['total']);
        
        $orderId = $this->order->save();
        
        if ($orderId) {
            
            foreach ($details as $detail) {
                $this->orderDetail->set('idOrder', $orderId);
                $this->orderDetail->set('idDish', $detail['idDish']);
                $this->orderDetail->set('quantity', $detail['quantity']);
                $this->orderDetail->set('price', $detail['price']);
                if (!$this->orderDetail->save()) {
                    return false;
                }
            }
            return true;
        }
        return false;
    }

    public function cancel($id) {
        $this->order->set('id', $id);
        return $this->order->cancel();
    }

    public function getOrdersBetween($start, $end)
    {
        return $this->order->getOrdersBetweenDates($start, $end);
    }

    public function getTotalBetween($start, $end)
    {
        return $this->order->getTotalBetweenDates($start, $end);
    }

public function getRankingBetween($start, $end)
{
    $order = new Order();
    return $order->getMostSoldDishesBetweenDates($start, $end);
}
public function getCancelledOrdersBetween($start, $end)
{
    $order = new Order();
    return $order->getCancelledOrdersBetweenDates($start, $end);
}

public function getCancelledTotalBetween($start, $end)
{
    $order = new Order();
    return $order->getCancelledTotalBetweenDates($start, $end);
}

public function getById($id)
{
    $order = new Order();
    return $order->findWithDetails($id);
}


} 