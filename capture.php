<?php
require __DIR__ . '/vendor/autoload.php';
include __DIR__ . '/bootstrap.php';

use PayPal\PayPalOrder;

// 根据授权码，Capture资金
$authorizationId = '';
$order = PayPalOrder::captureAuth($authorizationId);

echo json_encode($order->result);