
# Gopay支付平台快速接入 PHP-SDK

### 安装

```shell
composer install gopayplus/gopay-php-sdk
```
## 快速使用

### 订单查询
```php
$Config = new Config("host", "merchant_id",  "app_id", "secret");
$Transfer = new Transfer($Config);
$Transfer->query("order_no");
```

注：为了提高开发者问题的响应时效，请联系我们官方支付渠道。