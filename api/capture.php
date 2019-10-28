<?php
require __DIR__ . '/../vendor/autoload.php';
include __DIR__ . '/../bootstrap.php';

use PayPal\PayPalOrder;

$order = PayPalOrder::capture($_POST['orderId']);
echo json_encode($order->result);