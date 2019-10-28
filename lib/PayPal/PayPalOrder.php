<?php

namespace PayPal;

use PayPalCheckoutSdk\Orders\OrdersGetRequest;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersAuthorizeRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalCheckoutSdk\Payments\AuthorizationsCaptureRequest;

class PayPalOrder
{
    public static $client = null;

    public static $env = '';

    public static function client()
    {
        if (empty($client)) {
            self::$client = PayPalClient::client();
        }
        return self::$client;
    }

    // Get Transaction Details
    // If you require the complete order resource representation,
    // you must pass the Prefer: return=representation request header.
    // This header value is not the default.
    public static function order($orderId)
    {
        $client = self::client();
        return $client->execute(new OrdersGetRequest($orderId));
    }

    // Set Up Transaction or Set Up Authorization
    public static function create($body)
    {
        //[
        //    'intent' => 'CAPTURE', //AUTHORIZE
        //    'application_context' => [
        //        'brand_name' => 'EXAMPLE INC',
        //        'locale' => 'en-US',
        //        'landing_page' => 'BILLING',
        //        'shipping_preferences' => 'SET_PROVIDED_ADDRESS',
        //        'user_action' => 'PAY_NOW',
        //    ],
        //    'purchase_units' => [
        //        0 => [
        //            'reference_id' => 'PUHF',
        //            'description' => 'Sporting Goods',
        //            'custom_id' => 'CUST-HighFashions',
        //            'soft_descriptor' => 'HighFashions',
        //            'amount' => [
        //                'currency_code' => 'USD',
        //                'value' => '220.00',
        //                'breakdown' => [
        //                    'item_total' => [
        //                        'currency_code' => 'USD',
        //                        'value' => '180.00',
        //                    ],
        //                    'shipping' => [
        //                        'currency_code' => 'USD',
        //                        'value' => '20.00',
        //                    ],
        //                    'handling' => [
        //                        'currency_code' => 'USD',
        //                        'value' => '10.00',
        //                    ],
        //                    'tax_total' => [
        //                        'currency_code' => 'USD',
        //                        'value' => '20.00',
        //                    ],
        //                    'shipping_discount' => [
        //                        'currency_code' => 'USD',
        //                        'value' => '10.00',
        //                    ],
        //                ],
        //            ],
        //            'items' => [
        //                0 => [
        //                    'name' => 'T-Shirt',
        //                    'description' => 'Green XL',
        //                    'sku' => 'sku01',
        //                    'unit_amount' => [
        //                        'currency_code' => 'USD',
        //                        'value' => '90.00',
        //                    ],
        //                    'tax' => [
        //                        'currency_code' => 'USD',
        //                        'value' => '10.00',
        //                    ],
        //                    'quantity' => '1',
        //                    'category' => 'PHYSICAL_GOODS',
        //                ],
        //                1 => [
        //                    'name' => 'Shoes',
        //                    'description' => 'Running, Size 10.5',
        //                    'sku' => 'sku02',
        //                    'unit_amount' => [
        //                        'currency_code' => 'USD',
        //                        'value' => '45.00',
        //                    ],
        //                    'tax' => [
        //                        'currency_code' => 'USD',
        //                        'value' => '5.00',
        //                    ],
        //                    'quantity' => '2',
        //                    'category' => 'PHYSICAL_GOODS',
        //                ],
        //            ],
        //            'shipping' => [
        //                'method' => 'United States Postal Service',
        //                'address' => [
        //                    'address_line_1' => '123 Townsend St',
        //                    'address_line_2' => 'Floor 6',
        //                    'admin_area_2' => 'San Francisco',
        //                    'admin_area_1' => 'CA',
        //                    'postal_code' => '94107',
        //                    'country_code' => 'US',
        //                ],
        //            ],
        //        ],
        //    ],
        //];
        $client = self::client();
        $request = new OrdersCreateRequest();
        $request->body = $body;
        $request->prefer("return=representation");
        return $client->execute($request);
    }

    public static function authorize($orderId)
    {
        $client = self::client();
        $request = new OrdersAuthorizeRequest($orderId);
        $request->body = "{}";
        return $client->execute($request);
    }

    public static function capture($orderId)
    {
        $client = self::client();
        $request = new OrdersCaptureRequest($orderId);
        $request->prefer('return=representation');
        return $client->execute($request);
    }

    public static function captureAuth($authorizationId)
    {
        $client = self::client();
        $request = new AuthorizationsCaptureRequest($authorizationId);
        $request->body = "{}";
        return $client->execute($request);
    }
}