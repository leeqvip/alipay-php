<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
require_once dirname(__FILE__) . '/vendor/autoload.php';
use TechOne\Alipay\Pay;
// 强烈建议：将配置存放你的应用配置文件中，再这里读取配置。
$configs = [
    //  支付宝网关
    'gateway_url'          => 'https://openapi.alipaydev.com/gateway.do',
    // APPID 即创建应用后生成
    'app_id'               => '2016091300500827',
    // 开发者私钥，由开发者自己生成 ， https://docs.open.alipay.com/200/105310
    'rsa_private_key'      => 'MIIEpAIBAAKCAQEAxprnqk422m1XWxMNa3Mz4DKxjro7Fo9v560yCS7/TDExEIsEnj1s5x+n3+0xaR9HYfcvhCIP70j4mCY2xWNxeKKLALu88PVKI4V+v/CU5oO3Tm2t88B6ks+qc3s6SEaP6LH6UriZncKxbZcQQd09wwelmikwJXRGnQkKfthW+k8dlnH3IIIlzAdGR8u8veHYtVpBhndDrQdtAgANwjOgcEW5oJ9zlzJBpmzu4XqU1zSfP3XrlNNdT+2Xk7+TrZSbcIpguBQHo/jeAHAqVDCH6YV9kkYsFkvQXpVm5t+gPWA1z8DkLwSWTH2zHftCRpr9qn4yV/wz9YkE51kPpvmh2wIDAQABAoIBAA4wPuCx2cVdDmKZR9onTstzk6/IqjQAZ1Q70VlKnD6LPSAbbmcHqGISpuGehmsmKulayXA9JrpHkkr8X+lWI2Mk6Z1RzDvCqltDTDzWKS0Wt9/Igibp11fpshmx8gX71IghPurt+TuGDzrvEeBCuAjY4QHUc3YZinnpjXBmcEBNimj4v7Ft4pAymKaqv20pjgjUeBbi80hSiFhr48HNLd/knafncQSwH1l5vN1sQ4ABwsqUaI6m3dO+wGNSZ3m04K2twvMCt28QMJt11qhlFFEWF7qB12aBK7CG6NC5atHcc9EVF+/Mp3iHMh6xDnDoZamnOfBYl8dOZZRa2mkTOzECgYEA6VkGt4lfy262qCPv7eC1a/ShtbIb7dUIeyTsNdeujPHpVGzo+dOMY9XCrLhYtPM8rDhg5zHLhzpi0ZHRkdNkTrZTmKgkC8qX+ZUfEa6GGY9UJ/wBf+xbnreG+EYF3O210XHKFDsAkgZ7Hj6+ncWMe0VcI6yNznAouBK0L23ORCUCgYEA2eJ7SYgs9fjdF6x50iZHQr1Np/gPGwzvDUJvzRtZrhAaspjOX7sOTGUcFA8LTAccpiHq9nDXQafvz2h2HE9l3NOrbc1byJLddzFVksiseEtoS5pWgJ8itJEnEq5J4HBnDAieEdhtCZE1uWcZzkeZd+Trnu6nzRXvEbzj7o2Abf8CgYEAohnlT6TP9ktv+jgU2eRLQ7aKi+Ux/7MJFDrfGLw/FsyKscqCweJS2ZvKhCAAB5wdnun/bzwpTkSiF0G8GxiFyyRfyGGtwL85efk8vxTFNYZbCPfItuwj7YtC6MAEHKjJsLjij9E5ITf9WVJvKrzsTUouqt2ZGTrTHqRnpbcbHj0CgYBVaZZA9hQB/KPXMvKycfT/cawui2yIgyJ3BTNEqVMXjBKbLpHAL1jkk8JVDqy0Chmt+p/cKdIIV+gHW4Dpiip5TbTnH1i6oPAWWI2eM/KAWbcx4/fDBh8Zv8kcZpxpUkbjDcHBZyEfXgA8hPE1zxWXTXMcY5v+JnoIbw6/JlNRSwKBgQCoC1p3onqM3C/VcgprPfz2eiCNL7XW2FMZyugutBqt8l8D5NAwk5LM134VqOIs5CfpvmwaQOH+LioGwLcu4YdQJGvjsGekrenDMZSb+0wtFWFu3Nnv9Rw3K7/EspNfXJT2pAE3gvgzwTzAzcATNjRZ1yR8Ytm+7WAN67ne9+htdA==',
    // 支付宝公钥，由支付宝生成，https://docs.open.alipay.com/200/105310
    'alipayrsa_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAsLdX90sPWIRUcrrxr3btTQjjOZn1mHWeluj8XXVX0jBT24ihiez5supY2Z712NieBFdqY/IRr7vSZ0l1ZyScXfe/5sechCRIwtlgGOew+sRBeRuUy9ci+oQllxCnPNFHsD+ymW71qOcDMFFKNcW6zKPNVaIFwUsE4C6vIvDwEhkPJDNfbtBBgQU20+1FYr4yjg7mdEocKlWz4RrOuBZYwpwPoh9EsxJcignz4BfEEqbi5MgHYVyxH9OxIwNDX9uu8CQ/zz6Q6dtoYPibvlySnc5K3oCxOlDMs9W/YjaGKzLo5i3M0YK8FxQAvhP7HHzrbcj39j56fQsrB44lIduB2wIDAQAB',
    // 参数返回格式，只支持json
    'format'               => 'json',
    // 编码集，支持GBK/UTF-8
    'post_charset'         => 'UTF-8',
    // 商户生成签名字符串所使用的签名算法类型，目前支持RSA2和RSA，推荐使用RSA2
    'sign_type'            => 'RSA2',
    //该笔订单允许的最晚付款时间，逾期将关闭交易。取值范围：1m～15d。m-分钟，h-小时，d-天，1c-当天（1c-当天的情况下，无论交易何时创建，都在0点关闭）。 该参数数值不接受小数点， 如 1.5h，可转换为 90m。注：若为空，则默认为15d。
    'timeout_express'      => '30m',
    'notify_url'           => '商户外网可以访问的异步地址',
    'return_url'           => "http://yii2.loc/return_url.php",
];
$bizcontent = [
    // [可选]对一笔交易的具体描述信息。如果是多种商品，请将商品描述字符串累加传给body
    // 'body'            => '我是测试数据',
    // [必填]商品的标题/交易标题/订单标题/订单关键字等。
    'subject'      => 'App支付测试',
    // [必填]商户网站唯一订单号
    'out_trade_no' => '20170125test011',
    // [必填]订单总金额，单位为元，精确到小数点后两位，取值范围[0.01,100000000]
    'total_amount' => '0.01',
    // [可选]该笔订单允许的最晚付款时间，逾期将关闭交易。默认为配置中的timeout_express值
    // 'timeout_express' => '30m',
];
echo '<pre>';
// 支付实例类型，page|电脑网站支付，wap|手机网站支付，app|App支付，更多敬请期待
$pay = Pay::init('page', $configs);

// ----------------华丽的分割线-------------------------------------------------------------------

// 下单
// 如果是电脑网站支付、手机网站支付，执行execute方法后页面将自动跳转至支付宝支付页面，用户支付完成后，返回至return_url地址，并异步通知notify_url地址。
// 如果是app支付，执行execute方法后会返回一串app请求所用的orderstring，例如：alipay_sdk=alipay-sdk-php-20161101&app_id=2016091300500827&biz_conten……
$result = $pay->biz($bizcontent)->execute();
// 可选用法
// 1、是否自动跳转至支付宝支付页面，
$jumpAuto = false; // 如果为false，将返回一个html表单字符串
$result   = $pay->biz($bizcontent)->execute($jumpAuto);
echo $result;
// 2、针对每笔订单独立设置异步通知地址或返回地址
$pay->setNotifyUrl('异步地址');
$pay->setReturnUrl('同步地址');

// ----------------华丽的分割线-------------------------------------------------------------------
//
// 查询订单
$result = $pay->query('20170125test01');
// 订单是否成功
$result = $pay->isSuccess('20170125test01');

// ----------------华丽的分割线-------------------------------------------------------------------

// 退款
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

// ----------------华丽的分割线-------------------------------------------------------------------

// 交易关闭
$bizcontent = [
];
$result = $pay->close('20170125test01');
if ($result->code == 10000) {
    // 成功
}
var_dump($result);

// ----------------华丽的分割线-------------------------------------------------------------------
//
// 同步/异步通知 验证签名
// 特别提醒：在服务端接收同步或异步通知是，一定要先验证签名，验证通过后，再进行订单处理
// 验证签名
$data = $_GET | $_POST参数。; // 异步通知为post（ $_POST）参数。
$flag = $pay->check($data);
// 特别提醒：
/* 实际验证过程建议商户添加以下校验。
1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
4、验证app_id是否为该商户本身。
 */
if ($flag) {
//验证成功
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //请在这里加上商户的业务逻辑程序代
    //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
    //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
    //商户订单号
    $out_trade_no = $data['out_trade_no'];
    //支付宝交易号
    $trade_no = $data['trade_no'];
    //交易状态
    $trade_status = $data['trade_status'];
    if ($data['trade_status'] == 'TRADE_FINISHED') {
        //判断该笔订单是否在商户网站中已经做过处理
        //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
        //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
        //如果有做过处理，不执行商户的业务程序
        //注意：
        //退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知
    } elseif ($data['trade_status'] == 'TRADE_SUCCESS') {
        //判断该笔订单是否在商户网站中已经做过处理
        //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
        //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
        //如果有做过处理，不执行商户的业务程序
        //注意：
        //付款完成后，支付宝系统发送该交易状态通知
    }
    //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
    echo "success"; //请不要修改或删除
} else {
    //验证失败
    echo "fail"; //请不要修改或删除
}
