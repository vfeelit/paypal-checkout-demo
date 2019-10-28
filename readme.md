# PayPal Checkout Demo

## 克隆项目并安装依赖
```bash
#下载
git clone https://github.com/vfeelit/paypal-checkout-demo.git
#进入目录
cd paypal-checkout-demo

#安装依赖
composer -vvv install
```

## 文件说明
集成方式有两种，一种是基本集成，客户付款，马上划款；另一种是客户付款，取到客户的一个授权，之后再获取付款。
每种方式，API调用可以在客户端完成，也可以在服务器端完成。配置项在文件bootstrap.php中，其中的$model指定API是在客户端还是服务器端进行。

文件：basic.php 基础集成，文件：authorize.php 预授权方式集成，文件：demo.php 是演示所谓的Marks按钮。



