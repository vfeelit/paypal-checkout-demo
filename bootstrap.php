<?php
######
#运行模式，服务器端或客户端（API交互模式）
$model = "server";
#环境，固定为"sandbox"或"production"
$env = 'sandbox';
#凭证
$credentials = [
    'production' => [
        'client' => '',
        'secret' => ''
    ],
    'sandbox' => [
        'client' => "ATamFHF2zQad4c1kBBvwnbWOzcZt4I5afdQtQXVavZAiQFnVAS0ky6aMH_gMfX7sHhKi1opfdR1CXkPx",
        'secret' => "EDARMhZZSdwUpOe38H9pJYXtvmVBaXhNkJVyQL1yl5SWPr6DAJs1YPJHzZNU8yhlXdUQoKDIL0eiM9QR"
    ]
];

#######
#客户端JavaScript SDK配置
#https://developer.paypal.com/docs/checkout/reference/customize-sdk/
# 1 查询参数部分
$sdkConfigs = [
    #必须，App的编号。如果是sandbox环境，可以直接指定为"sb"
    "client-id" => $credentials[$env]['client'],
    #自动填充，商户编号（卖家编号），集成方案是Partner or Marketplace时，必须指定
    //"merchant-id" => "",
    #默认"USD"，币种
    #支持币种：https://developer.paypal.com/docs/checkout/reference/customize-sdk/#currency
    //"currency" => "USD",
    #默认capture，可以是capture和authorize，对应两种获取资金的方式。capture表示马上划款，authorize是先获取客户授权，后续根据授权码划款
    //"intent" => "capture",
    #默认是true，最终付款时，显示"立即付款"还是"继续"
    //"commit" => "true",
    #默认是false，为交易设置一个保管库？？？
    //"vault" => "false",
    #默认是buttons，可以是buttons和marks。多个值必须使用逗号分隔，逗号不能转义
    #这里的marks大体意思是在按钮之后插入一个"污点"，集成另外一种支付方式
    #https://developer.paypal.com/docs/checkout/integration-features/mark-flow/
    //"components" => "buttons",
    #默认是none，禁用哪些资金来源
    //"disable-funding" => "none",
    #默认是none，禁用哪些信用卡
    //"disable-card" => "none",
    #默认自动填充，默认值是App创建时的日期（用来做向后兼容）
    //"integration-date" => "",
    #默认是false，是否启动调试
    "debug" => "false",
    #买家所在国家，默认是自动填充，这里主要用来测试
    "buyer-country" => "US",
    #默认自动填充，本地化
    #https://developer.paypal.com/docs/checkout/reference/customize-sdk/#locale
    //"locale" => "",
];
# 2 属性部分
#https://developer.paypal.com/docs/checkout/reference/customize-sdk/#script-parameters
$sdkAttrConfigs = [

];

#客户端按钮配置
#https://developer.paypal.com/docs/checkout/integration-features/customize-button/
$buttonConfig = [
    // vertical，horizontal
    "layout" => 'vertical',
    // gold，blue，silver，white，black
    "color" => 'gold',
    // rect, pill
    "shape" => 'rect',
    // 文档说明：
    // 按钮会根据容器元素的大小进行调整，如果指定了高度和宽度，如果小于最小尺寸，实际还是会溢出（垂直最小宽200px，水平最小宽150px）
    // 要定义按钮高度，更改容器元素的宽度
    // 要定义按钮的高度，将style.height选项设置为25到55之间的值
    // 所以size字段应该已经无效（medium | large | responsive）- 估计是旧版本可以指定？
    //"size" => 'large',
    // paypal, checkout, buynow, pay, installment
    "label" => 'checkout',
    // 是否在按钮下方显示一行标语（比如：更安全、更便捷的付款方式），一般建议是false
    // 在垂直布局的情况下，按钮下面总是显示一行文字，并且不能指定tagline为true（JS报错）
    // true, false 当layout是vertical时，tagline不能是true
    "tagline" => false
];

#######
#初始化
\PayPal\PayPalClient::$env = $env;
\PayPal\PayPalClient::$credentials = $credentials;