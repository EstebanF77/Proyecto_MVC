<?php
require_once '../../controller/OrderController.php';

$orderController = new OrderController();

$data = [
    'dateOrder' => $_POST['dateOrder'],
    'total' => $_POST['total'],
    'idTable' => $_POST['idTable']
];

$details = [];
foreach ($_POST['idDish'] as $i => $idDish) {
    $details[] = [
        'idDish' => $idDish,
        'quantity' => $_POST['quantity'][$i],
        'price' => $_POST['price'][$i]
    ];
}

$orderController->create($data, $details);
header('Location: ../listOrders.php');
exit; 