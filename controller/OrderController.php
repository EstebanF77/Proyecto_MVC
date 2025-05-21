<?php
namespace app\controller;


use App\models\entities\Order;
use App\models\entities\OrderDetail;


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

    public function getOrdersBetween($start, $end)
{
    $order = new Order();
    return $order->getOrdersBetweenDates($start, $end);
}

public function getTotalBetween($start, $end)
{
    $order = new Order();
    return $order->getTotalBetweenDates($start, $end);
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

} 