<?php
namespace TechOne\Alipay\handler;

/**
 * 支付宝APP支付
 * @author TechLee <techlee@qq.com>
 */
class App extends Base
{
    /**
     * 销售产品码，商家和支付宝签约的产品码
     * @return string 销售产品码
     */
    public function getProductCode()
    {
        return 'QUICK_MSECURITY_PAY';
    }

    /**
     * 获取app客户端请求参数字符串
     * @param  boolean $jumpAuto 无任何意义
     * @return string
     */
    public function execute($jumpAuto = true)
    {
        //实例化具体API对应的request类,类名称和接口名称对应,当前调用接口名称：alipay.trade.app.pay
        $request = new \AlipayTradeAppPayRequest();
        //SDK已经封装掉了公共参数，这里只需要传入业务参数
        $request->setNotifyUrl($this->getNotifyUrl());
        $request->setBizContent(json_encode($this->bizcontent));
        //这里和普通的接口调用不同，使用的是sdkExecute
        $response = $this->aop->sdkExecute($request);
        //htmlspecialchars是为了输出到页面时防止被浏览器将关键参数html转义，实际打印到日志以及http传输不会有这个问题
        return htmlspecialchars($response); //就是orderString 可以直接给客户端请求，无需再做处理。
    }

}
