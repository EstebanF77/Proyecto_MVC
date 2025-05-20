<?php
require_once '../../controller/OrderController.php';
$orderController = new OrderController();
$res = $orderController->cancel($_GET['id'] ?? null);
header('Location: ../listOrders.php');
exit; 