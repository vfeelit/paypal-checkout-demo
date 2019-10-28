<?php
#文档：https://developer.paypal.com/docs/checkout/integration-features/mark-flow/
#该文档描述的例子无法正确跑起来
#实际上这里描述的是如何提供另外一种支付方式

require __DIR__ . '/vendor/autoload.php';
include __DIR__ . '/bootstrap.php';

if (isset($sdkConfigs['components'])) {
    unset($sdkConfigs['components']);
}
?>
<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
</head>

<body>
<script src="./jquery.min.js"></script>
<script src="https://www.paypal.com/sdk/js?<?php echo http_build_query($sdkConfigs); ?>&components=buttons,marks"></script>

<!-- Render the radio buttons and marks -->
<label>
    <input type="radio" name="payment-option" value="paypal" checked>
    <img src="paypal-mark.jpg" alt="Pay with PayPal">
</label>
<label>
    <input type="radio" name="payment-option" value="alternate">
    <div id="paypal-marks-container"></div>
</label>

<!-- 容器 -->
<div id="paypal-buttons-container"></div>
<div id="alternate-button-container">
    <button>Pay with a different method</button>
</div>

<script>
// Render the PayPal marks
paypal.Marks().render('#paypal-marks-container');

// Render the PayPal buttons
paypal.Buttons().render('#paypal-buttons-container');

$(function () {
    $('input[name=payment-option]').on('change', function () {
        var v = $(this).val();
        if (v === 'paypal') {
            $("#paypal-buttons-container").show();
            $("#alternate-button-container").hide();
        }
        if (v === 'alternate') {
            $("#paypal-buttons-container").hide();
            $("#alternate-button-container").show();
        }
    });
    $('#alternate-button-container').hide();
});
</script>
</body>