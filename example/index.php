<?php

// 如果是使用支持composer自动加载的框架（比如thinkphp，laravel），则无需require。
require_once dirname(__FILE__) . '/../vendor/autoload.php';

use TechOne\Alipay\Pay;

$configs = [
    // https://openapi.alipaydev.com/gateway.do
    'gateway_url'          => 'https://openapi.alipaydev.com/gateway.do',
    'app_id'               => '2016091300500827',
    'rsa_private_key'      => 'MIIEpAIBAAKCAQEAxprnqk422m1XWxMNa3Mz4DKxjro7Fo9v560yCS7/TDExEIsEnj1s5x+n3+0xaR9HYfcvhCIP70j4mCY2xWNxeKKLALu88PVKI4V+v/CU5oO3Tm2t88B6ks+qc3s6SEaP6LH6UriZncKxbZcQQd09wwelmikwJXRGnQkKfthW+k8dlnH3IIIlzAdGR8u8veHYtVpBhndDrQdtAgANwjOgcEW5oJ9zlzJBpmzu4XqU1zSfP3XrlNNdT+2Xk7+TrZSbcIpguBQHo/jeAHAqVDCH6YV9kkYsFkvQXpVm5t+gPWA1z8DkLwSWTH2zHftCRpr9qn4yV/wz9YkE51kPpvmh2wIDAQABAoIBAA4wPuCx2cVdDmKZR9onTstzk6/IqjQAZ1Q70VlKnD6LPSAbbmcHqGISpuGehmsmKulayXA9JrpHkkr8X+lWI2Mk6Z1RzDvCqltDTDzWKS0Wt9/Igibp11fpshmx8gX71IghPurt+TuGDzrvEeBCuAjY4QHUc3YZinnpjXBmcEBNimj4v7Ft4pAymKaqv20pjgjUeBbi80hSiFhr48HNLd/knafncQSwH1l5vN1sQ4ABwsqUaI6m3dO+wGNSZ3m04K2twvMCt28QMJt11qhlFFEWF7qB12aBK7CG6NC5atHcc9EVF+/Mp3iHMh6xDnDoZamnOfBYl8dOZZRa2mkTOzECgYEA6VkGt4lfy262qCPv7eC1a/ShtbIb7dUIeyTsNdeujPHpVGzo+dOMY9XCrLhYtPM8rDhg5zHLhzpi0ZHRkdNkTrZTmKgkC8qX+ZUfEa6GGY9UJ/wBf+xbnreG+EYF3O210XHKFDsAkgZ7Hj6+ncWMe0VcI6yNznAouBK0L23ORCUCgYEA2eJ7SYgs9fjdF6x50iZHQr1Np/gPGwzvDUJvzRtZrhAaspjOX7sOTGUcFA8LTAccpiHq9nDXQafvz2h2HE9l3NOrbc1byJLddzFVksiseEtoS5pWgJ8itJEnEq5J4HBnDAieEdhtCZE1uWcZzkeZd+Trnu6nzRXvEbzj7o2Abf8CgYEAohnlT6TP9ktv+jgU2eRLQ7aKi+Ux/7MJFDrfGLw/FsyKscqCweJS2ZvKhCAAB5wdnun/bzwpTkSiF0G8GxiFyyRfyGGtwL85efk8vxTFNYZbCPfItuwj7YtC6MAEHKjJsLjij9E5ITf9WVJvKrzsTUouqt2ZGTrTHqRnpbcbHj0CgYBVaZZA9hQB/KPXMvKycfT/cawui2yIgyJ3BTNEqVMXjBKbLpHAL1jkk8JVDqy0Chmt+p/cKdIIV+gHW4Dpiip5TbTnH1i6oPAWWI2eM/KAWbcx4/fDBh8Zv8kcZpxpUkbjDcHBZyEfXgA8hPE1zxWXTXMcY5v+JnoIbw6/JlNRSwKBgQCoC1p3onqM3C/VcgprPfz2eiCNL7XW2FMZyugutBqt8l8D5NAwk5LM134VqOIs5CfpvmwaQOH+LioGwLcu4YdQJGvjsGekrenDMZSb+0wtFWFu3Nnv9Rw3K7/EspNfXJT2pAE3gvgzwTzAzcATNjRZ1yR8Ytm+7WAN67ne9+htdA==',
    'format'               => 'json',
    'post_charset'         => 'UTF-8',
    'sign_type'            => 'RSA2',
    'alipayrsa_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAsLdX90sPWIRUcrrxr3btTQjjOZn1mHWeluj8XXVX0jBT24ihiez5supY2Z712NieBFdqY/IRr7vSZ0l1ZyScXfe/5sechCRIwtlgGOew+sRBeRuUy9ci+oQllxCnPNFHsD+ymW71qOcDMFFKNcW6zKPNVaIFwUsE4C6vIvDwEhkPJDNfbtBBgQU20+1FYr4yjg7mdEocKlWz4RrOuBZYwpwPoh9EsxJcignz4BfEEqbi5MgHYVyxH9OxIwNDX9uu8CQ/zz6Q6dtoYPibvlySnc5K3oCxOlDMs9W/YjaGKzLo5i3M0YK8FxQAvhP7HHzrbcj39j56fQsrB44lIduB2wIDAQAB',
    'timeout_express'      => '30m',
    'notify_url'           => '商户外网可以访问的异步地址',
    'return_url'           => "http://yii2.loc/return_url.php",

];

$bizcontent = [
    'body'            => '我是测试数据',
    'subject'         => 'App支付测试',
    'out_trade_no'    => '20170125test01',
    'timeout_express' => '30m',
    'total_amount'    => '0.01',
    'product_code'    => 'QUICK_MSECURITY_PAY',
];
echo '<pre>';

$pay = Pay::init('wap', $configs);
// 下单
// $result = $pay->biz($bizcontent)->execute();
// echo $result;
// 查询订单
$result = $pay->query('20170125test01');
// 订单是否成功
$result = $pay->isSuccess('20170125test01');
// 退款
// $bizcontent = [
//     'out_trade_no'  => '20170125test01', // 订单支付时传入的商户订单号,不能和 trade_no同时为空。
//     // 'trade_no'      => '2014112611001004680073956707', // 支付宝交易号，和商户订单号不能同时为空
//     'refund_amount' => '0.01', // 需要退款的金额，该金额不能大于订单金额,单位为元，支持两位小数
//     'refund_reason' => '正常退款', // 退款的原因说明
// ];
// $result = $pay->biz($bizcontent)->refund();
// if ($result->code == 10000) {
//     // 成功
// }
// 交易关闭
$bizcontent = [

];
$result = $pay->close('20170125test01');
if ($result->code == 10000) {
    // 成功
}
var_dump($result);
die;
