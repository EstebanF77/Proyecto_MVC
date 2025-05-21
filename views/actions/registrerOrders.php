<?php
require_once '../../controller/OrderController.php';

// Validate required fields
if (!isset($_POST['dateOrder']) || !isset($_POST['idTable']) || !isset($_POST['idDish']) || !isset($_POST['quantity'])) {
    die("Error: Faltan campos requeridos");
}

// Calculate total
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

// Prepare order data
$orderData = [
    'dateOrder' => $_POST['dateOrder'],
    'idTable' => $_POST['idTable'],
    'total' => $total
];

// Create order using controller
$orderController = new OrderController();
$result = $orderController->create($orderData, $orderDetails);

if ($result) {
    header('Location: ../listOrders.php');
    exit;
} else {
    echo "Error al registrar la orden";
}
?> 