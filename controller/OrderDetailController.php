<?php
namespace App\controller;

use App\models\entities\OrderDetail;

class OrderDetailController {
    public function getByOrderId($orderId) {
        $detail = new OrderDetail();
        return $detail->allByOrderId($orderId);
    }
}
