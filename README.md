# alipay-php 支付宝支付sdk

### 安装

```
composer require techleeone/alipay-php
```

### 使用

```
// 如果是使用支持composer自动加载的框架（比如thinkphp，laravel），则无需require。
require_once dirname(__FILE__) . '/vendor/autoload.php';
use TechOne\Alipay\Pay;
// 配置参数
$configs = [
    // https://openapi.alipaydev.com/gateway.do
    'gateway_url'          => 'https://openapi.alipay.com/gateway.do',
    'app_id'               => '', // 支付宝分配给开发者的应用ID
    'rsa_private_key'      => '', // 请填写开发者私钥去头去尾去回车，一行字符串
    'format'               => 'json',
    'post_charset'         => 'UTF-8',
    'sign_type'            => 'RSA2',
    'alipayrsa_public_key' => '', // 请填写支付宝公钥，一行字符串
    'timeout_express'      => '30m', //该笔订单允许的最晚付款时间，逾期将关闭交易。取值范围：1m～15d。m-分钟，h-小时，d-天，1c-当天（1c-当天的情况下，无论交易何时创建，都在0点关闭）。 该参数数值不接受小数点， 如 1.5h，可转换为 90m。注：若为空，则默认为15d。
    'notify_url'           => '商户外网可以访问的异步地址',
    'return_url'           => "同步返回地址",

];

```
### 获取实例

```
支付实例类型，page|电脑网站支付，wap|手机网站支付，app|App支付，更多敬请期待
$handler = 'wap';
$pay = Pay::init($handler, $configs);
```

### 下单

```
// 业务请求参数
$bizcontent = [
    'body'            => '我是测试数据',
    'subject'         => 'App支付测试',
    'out_trade_no'    => '20170125test01',
    'timeout_express' => '30m',
    'total_amount'    => '0.01',
    'product_code'    => 'FAST_INSTANT_TRADE_PAY', // FAST_INSTANT_TRADE_PAY|电脑网站支付 ， QUICK_MSECURITY_PAY|手机网站支付
];
$result = $pay->biz($bizcontent)->execute();
```
### 查询订单

```
// 查询订单
// $type     订单号类型，out_trade_no|商户订单号(默认)，trade_no|支付宝交易号
$result = $pay->query('20170125test01', $type);
// 订单是否成功
$result = $pay->isSuccess('20170125test01', $type);
```

### 退款

```
$bizcontent = [
    'out_trade_no'  => '20170125test01', // 订单支付时传入的商户订单号,不能和 trade_no同时为空。
    // 'trade_no'      => '2014112611001004680073956707', // 支付宝交易号，和商户订单号不能同时为空
    'refund_amount' => '0.01', // 需要退款的金额，该金额不能大于订单金额,单位为元，支持两位小数
    'refund_reason' => '正常退款', // 退款的原因说明
];
$result = $pay->biz($bizcontent)->refund();
if ($result->code == 10000) {
    // 成功
}
```

### 交易关闭

```
// $type     订单号类型，out_trade_no|商户订单号(默认)，trade_no|支付宝交易号
$result = $pay->close('20170125test01', $type);
if ($result->code == 10000) {
    // 成功
}
```

### 同步/异步通知 验证签名

```
$data = $_GET | $_POST参数。;// 异步通知为post（ $_POST）参数。
$flag = $pay->check($data);
```
