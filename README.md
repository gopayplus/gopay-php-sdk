
# 趣付宝（Gopay）支付平台快速接入 PHP-SDK

### 安装

```shell
composer require gopayplus/gopay-php-sdk
```
## 快速使用

### 转账-创建订单
```php
$Config = new Config($this->host,  $this->mch_id, $this->app_id, $this->secret);
$Transfer = new Transfer($Config);
$order_no = "T010030330202";
$account_name = "李白";
$account_no = "6224121229828888";
$bank_name = "湖北农信";
$bank_code = "PSBC";
$province = "湖北省";
$city = "荆州市";
$amount = 100; //分
$entry_code = EntryType::BANK_CARD.value; // $entry_code = 入账方式： WX_CASH-微信零钱; ALIPAY_CASH-支付宝转账; BANK_CARD-银行卡
$if_code = IfCode::ALIAQFPAY.value; // 安全发
$ip = "";
$remark = "";
$notify_url = "";
$data = $Transfer->transferOrder($if_code, $entry_code,$order_no, $amount, $account_no, $account_name, $bank_name, $ip, $remark, $notify_url);

```

### 转账-订单查询
```php
$Config = new Config("host", "merchant_id",  "app_id", "secret");
$Transfer = new Transfer($Config);
$Transfer->query("transfer_id", "out_order_no");
```


### 转账-额度查询
```php
$Config = new Config($this->host,  $this->mch_id, $this->app_id, $this->secret);
$Transfer = new Transfer($Config);
$Transfer->balance("aliaqfpay");
```
### 转账-查询回单
```php
$Config = new Config($this->host,  $this->mch_id, $this->app_id, $this->secret);
$Transfer = new Transfer($Config);
$Transfer->receipt("transfer_id", "out_order_no");
```



注：为了提高开发者问题的响应时效，请联系我们官方支付渠道。