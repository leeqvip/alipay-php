<?php
namespace TechOne\Alipay\handler;

/**
 * 电脑网站支付
 * @author TechLee <techlee@qq.com>
 */
class Page extends Base
{
    /**
     * 销售产品码，商家和支付宝签约的产品码
     * @return string 销售产品码
     */
    public function getProductCode()
    {
        return 'FAST_INSTANT_TRADE_PAY';
    }

    /**
     * 发起支付
     * @param  boolean $jumpAuto 自动跳转
     * @return string|void
     */
    public function execute($jumpAuto = true)
    {
        $request = new \AlipayTradePagePayRequest();
        //SDK已经封装掉了公共参数，这里只需要传入业务参数
        $request->setNotifyUrl($this->getNotifyUrl());
        $request->setReturnUrl($this->getReturnUrl());
        $request->setBizContent(json_encode($this->bizcontent));
        $result = $this->aop->pageExecute($request);
        if ($jumpAuto) {
            exit($result);
        }
        return $result;
    }
}
