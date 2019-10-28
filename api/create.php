<?php
require __DIR__ . '/../vendor/autoload.php';
include __DIR__ . '/../bootstrap.php';

use PayPal\PayPalOrder;

// Sample
$body = array(
    'intent' => isset($_GET['authorize']) ? 'AUTHORIZE' : 'CAPTURE',
    'application_context' =>
        array(
            'return_url' => 'https://example.com/return',
            // 点击取消时，回到哪个地址
            'cancel_url' => 'https://example.com/cancel'
        ),
    'purchase_units' =>
        array(
            0 =>
                array(
                    'reference_id' => "0001",
                    'custom_id' => "0001",
                    'amount' =>
                        array(
                            'currency_code' => 'USD',
                            'value' => '2.99'
                        )
                )
        )
);

$order = PayPalOrder::create($body);

echo json_encode($order->result);