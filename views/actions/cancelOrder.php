<?php
include '../models/drivers/conexDB.php';
include '../models/entities/model.php';
include '../models/entities/order.php';
include '../controller/OrderController.php';

use App\controller\OrderController;
$orderController = new OrderController();
$res = $orderController->cancel($_GET['id'] ?? null);
header('Location: ../listOrders.php');
exit; 