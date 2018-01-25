<?php
namespace TechOne\Alipay\handler;

use AlipayTradeCloseRequest;
use AlipayTradeQueryRequest;
use AlipayTradeRefundRequest;
use TechOne\Alipay\Helper;

/**
 * 支付宝交易基础类
 * @author TechLee <techlee@qq.com>
 */
abstract class Base
{
    /**
     * $aop
     * @var [type]
     */
    protected $aop;

    /**
     * 业务线参数
     * @var array
     */
    protected $bizcontent = [];

    /**
     * 签名类型
     * @var string
     */
    protected $signType = 'RSA';

    /**
     * 配置
     * @var array
     */
    protected $configs = [];

    public function __construct($configs = [])
    {
        require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'alipay-sdk-149/AopSdk.php';
        $this->configs = $this->mergeConfig($configs);
        // $this->sdkPath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'alipay-sdk-149' . DIRECTORY_SEPARATOR;

        $this->aop = new \AopClient;
        $this->configures($this->getConfigs());
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
        return $configs;
    }

    protected function mergeConfig($config = [])
    {
        return array_merge($this->getDefaultConfig(), $config);
    }

    protected function getDefaultConfig()
    {
        return require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'config/config.php';
    }

    abstract public function execute();

    /**
     * 配置
     * @return array [description]
     */
    protected function getConfigs()
    {
        return $this->configs;
    }

    /**
     * 获取单个配置
     * @param  string $name 配置名称
     * @return string       配置值
     */
    protected function config($name)
    {
        $configs = $this->getConfigs();
        return isset($configs[$name]) ? $configs[$name] : '';
    }

    /**
     * 将下划线命名转换为驼峰式命名
     * @param  string  $str     要转换的字符串
     * @param  boolean $ucfirst 首字母是否大小
     * @return string
     */
    public function convertVar($str, $ucfirst = true)
    {
        return Helper::studly_case($str, $ucfirst);
    }

    /**
     * 设置业务请求参数
     * @param  array  $bizcontent 业务线请求参数
     * @return class
     */
    public function biz($bizcontent = [])
    {
        $this->bizcontent = $bizcontent;
        return $this;
    }

    /**
     * 订单查询
     * @param  string $trade_no 订单号
     * @param  string $type     订单号类型，out_trade_no|商户订单号，trade_no|支付宝交易号
     * @return [type]           [description]
     */
    public function query($trade_no, $type = 'out_trade_no')
    {
        $request = new AlipayTradeQueryRequest();
        $request->setBizContent(json_encode([$type => $trade_no]));
        $result       = $this->aop->execute($request);
        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        return $result->$responseNode;
    }

    /**
     * 订单是否成功
     * @param  string $trade_no 订单号
     * @param  string $type     订单号类型，out_trade_no|商户订单号，trade_no|支付宝交易号
     * @return boolean          订单结果
     */
    public function isSuccess($trade_no, $type = 'out_trade_no')
    {
        $resultCode = $this->query($trade_no, $type)->code;
        if (!empty($resultCode) && $resultCode == 10000) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 退款
     * @return [type] [description]
     */
    public function refund()
    {
        $request = new AlipayTradeRefundRequest();
        $request->setBizContent(json_encode($this->bizcontent));
        $result       = $this->aop->execute($request);
        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        return $result->$responseNode;
    }

    /**
     * 关闭
     * @param  [type] $trade_no [description]
     * @param  string $type     [description]
     * @return [type]           [description]
     */
    public function close($trade_no, $type = 'out_trade_no')
    {
        $request = new AlipayTradeCloseRequest();
        $request->setBizContent(json_encode([$type => $trade_no]));
        $result       = $this->aop->execute($request);
        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        return $result->$responseNode;
    }

    /**
     * 验证
     * @param  array  $data [description]
     * @return [type]       [description]
     */
    public function check(array $data = [])
    {
        return $this->aop->rsaCheckV1($data, null, $this->signType);
    }
}
