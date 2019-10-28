<?php
require __DIR__ . '/../vendor/autoload.php';
include __DIR__ . '/../bootstrap.php';

use PayPal\PayPalOrder;

$orderId = $_POST['orderId'];
$order = PayPalOrder::order($orderId);

echo json_encode($order->result);