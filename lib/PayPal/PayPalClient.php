<?php

namespace PayPal;

use PayPalCheckoutSdk\Core\PayPalHttpClient;

class PayPalClient
{
    public static $env = 'production';

    public static $credentials = [
        'production' => [
            'client' => '',
            'secret' => ''
        ],
        'sandbox' => [
            'client' => "",
            'secret' => ""
        ]
    ];

    public static function client()
    {
        return new PayPalHttpClient(self::environment());
    }

    private static function environment()
    {
        if (!in_array(self::$env, ['production', 'sandbox'])) {
            self::$env = 'production';
        }
        $class = "\PayPalCheckoutSdk\Core\ProductionEnvironment";
        if (self::$env === 'sandbox') {
            $class = "\PayPalCheckoutSdk\Core\SandboxEnvironment";
        }
        return new $class(self::$credentials[self::$env]['client'], self::$credentials[self::$env]['secret']);
    }
}