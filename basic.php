<?php
require __DIR__ . '/vendor/autoload.php';
include __DIR__ . '/bootstrap.php';
?>
<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
</head>

<body>
<script src="https://www.paypal.com/sdk/js?<?php echo http_build_query($sdkConfigs); ?>"></script>

<?php
// 这里指定了容器的宽度和高度，而按钮最小宽度和高度大于这个值，会溢出
// 如果大于最小值，就会按照给定的值自适应渲染
// 从渲染结果（PC端），
// 1 垂直布局，宽度最小200px，高度最好不要设置
// 2 水平布局，宽度最小150px，高度最好不要设置
?>
<div id="paypal-button-container" style="width: 220px;"></div>

<script>
// 按钮的env可不指定，会自动填充判断
paypal.Buttons({
    env: '<?php echo $env; ?>',
    style: <?php echo json_encode($buttonConfig); ?>,
    createOrder: function(data, actions) {
        var model = "<?php echo $model; ?>";
        if (model === 'client') {
            return actions.order.create({
                purchase_units: [{
                    reference_id: "0001",
                    custom_id: "0001",
                    amount: {
                        value: '0.2'
                    }
                }]
            });
        } else {
            return fetch('/api/create.php', {
                method: 'post',
                headers: {
                    'content-type': 'application/json'
                }
            }).then(function (res) {
                return res.json();
            }).then(function (data) {
                return data.id;
            });
        }
    },
    onApprove: function(data, actions) {
        var form = new FormData();
        form.append('orderId', data.orderID);
        var model = "<?php echo $model; ?>";
        if (model === 'client') {
            return actions.order.capture().then(function (details) {
                alert('Transaction completed by ' + details.payer.name.given_name);
                return fetch('/api/order.php', {
                    method: 'POST',
                    body: form
                });
            });
        } else {
            return fetch('/api/capture.php', {
                method: 'POST',
                body: form
            }).then(function (res) {
                return res.json();
            }).then(function (details) {
                if (details.error === 'INSTRUMENT_DECLINED') {
                    return action.restart();
                }
                alert("Success");
                return fetch('/api/order.php', {
                    method: 'post',
                    body: form
                });
            });
        }
    }
}).render('#paypal-button-container');
</script>
</body>