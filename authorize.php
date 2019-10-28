<?php
require __DIR__ . '/vendor/autoload.php';
include __DIR__ . '/bootstrap.php';

$sdkConfigs['intent'] = "authorize";
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
paypal.Buttons({
    env: '<?php echo $env; ?>',
    style: <?php echo json_encode($buttonConfig); ?>,
    createOrder: function(data, actions) {
        var model = "<?php echo $model; ?>";
        if (model === 'client') {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: '0.1'
                    }
                }]
            });
        } else {
            return fetch('/api/create.php?authorize=true', {
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
        var model = "<?php echo $model; ?>";
        if (model === 'client') {
            return actions.order.authorize().then(function(authorization) {
                var authorizationID = authorization.purchase_units[0].payments.authorizations[0].id;
                alert(authorizationID);
                var form = new FormData();
                form.append('orderId', data.orderID);
                // 把授权码传递回去
                form.append('authorizationId', authorizationID);
                return fetch('/api/order.php', {
                    method: 'POST',
                    body: form
                });
            });
        } else {
            var form = new FormData();
            form.append('orderId', data.orderID);
            return fetch('/api/authorize.php', {
                method: 'POST',
                body: form
            }).then(function(res) {
                return res.json();
            }).then(function(details) {
                alert('Authorization created for ' + details.payer.name.given_name);
            });
        }
    }
}).render('#paypal-button-container');
</script>
</body>