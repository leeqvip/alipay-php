<?php
namespace TechOne\Alipay;

/**
 *
 */
class App
{
    protected $aop = '';

    protected $bizcontent = [];

    protected $notifyUrl = '';

    public function __construct($configs = [])
    {
        require_once dirname(__FILE__) . '/alipay-sdk-149/AopSdk.php';
        $this->aop = new \AopClient;
        $this->configures($configs);
    }

    protected function configures($configs)
    {
        foreach ($configs as $key => $value) {
            $config = $this->convertVar($key, false);
            if (property_exists($this->aop, trim($config))) {
                $this->aop->$config = $value;
            }
            if (property_exists($this, trim($config))) {
                $this->$config = $value;
            }
        }
    }

    //将下划线命名转换为驼峰式命名
    public function convertVar($str, $ucfirst = true)
    {
        while (($pos = strpos($str, '_')) !== false) {
            $str = substr($str, 0, $pos) . ucfirst(substr($str, $pos + 1));
        }
        return $ucfirst ? ucfirst($str) : $str;
    }

    public function biz($bizcontent = [])
    {
        $this->bizcontent = $bizcontent;
        return $this;
    }

    public function orderString()
    {
        //实例化具体API对应的request类,类名称和接口名称对应,当前调用接口名称：alipay.trade.app.pay
        $request = new \AlipayTradeAppPayRequest();
        //SDK已经封装掉了公共参数，这里只需要传入业务参数
        $request->setNotifyUrl($this->notifyUrl);
        $request->setBizContent(json_encode($this->bizcontent));
        //这里和普通的接口调用不同，使用的是sdkExecute
        $response = $this->aop->sdkExecute($request);
        //htmlspecialchars是为了输出到页面时防止被浏览器将关键参数html转义，实际打印到日志以及http传输不会有这个问题
        return htmlspecialchars($response); //就是orderString 可以直接给客户端请求，无需再做处理。
    }
}
