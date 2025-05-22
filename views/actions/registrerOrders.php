<?php
include '../../models/drivers/conexDB.php';
include '../../models/entities/model.php';
include '../../models/entities/order.php';
include '../../controller/OrderController.php';

use App\controller\OrderController;

if (!isset($_POST['dateOrder']) || !isset($_POST['idTable']) || !isset($_POST['idDish']) || !isset($_POST['quantity'])) {
    if (isset($_GET['dateOrder']) && isset($_GET['idTable']) && isset($_GET['idDish']) && isset($_GET['quantity'])) {
        $_POST = $_GET;
    } else {
        die("Error: Faltan campos requeridos");
    }
}


$total = 0;
$orderDetails = [];

foreach ($_POST['idDish'] as $index => $dishId) {
    if (isset($_POST['quantity'][$index])) {
        $quantity = (int)$_POST['quantity'][$index];
        $price = (float)$_POST['price'][$index];
        $total += $quantity * $price;
        
        $orderDetails[] = [
            'idDish' => $dishId,
            'quantity' => $quantity,
            'price' => $price
        ];
    }
}

$orderData = [
    'dateOrder' => $_POST['dateOrder'],
    'idTable' => $_POST['idTable'],
    'total' => $total
];


$orderController = new OrderController();
$result = $orderController->create($orderData, $orderDetails);

if ($result) {
    header('Location: ../listOrders.php');
    exit;
} else {
    echo "Error al registrar la orden";
}
?> 