<?php
namespace common\components\alipay;

use common\components\alipay\lib\AlipayNotify;
use common\components\alipay\web\AlipayTradePagePayRequest;
use common\components\alipay\web\AopClient;

/**
 * 支付宝WEB版支付接口
 */
class alipayWeb
{
    const PAY_PRODUCT_CODE = "FAST_INSTANT_TRADE_PAY";
    const PAY_FORAMT = "JSON";
    const PAY_VERSION = "1.0";
    /**
     * 支付配置
     */
    public static $config = array (
            //应用ID,您的APPID。
            'app_id' => "2017072407882824",
            //商户私钥
            'merchant_private_key' => "MIICWwIBAAKBgQC69GzMrLujT3gTA2AOatNtaynaafrDVwMcaB7vYS0NjIhe6gJjOIWBwTMQK8ExrcPY/VAoEb4qlPVRqJLbA6YRvR9MnOz7uMIGDzkDFCR8rOfoiipmVFwD8qSqBfy7c2f0yBANGk3ZZRWvrO29FC4u0CpD3jW4XlR+uWSox7x5TwIDAQABAoGAVohX64xv9TENRM+lIEc1wUl+v8eZ99xIZleTKf1ymvjXDgeGP2Kj+ODxv6Rg8ZuaMM9e0I0V1iPIQJmkD5dqv7RooI69WovGwoGVALN8sm+R51XqrR0NLbdDsQMSWoaxpRzNIrNAGrIOBB/Pb2zF/Tha89EnBcFzAfxoz7cMYvECQQDlXtFgUOcKWrCU5AXkJyiW3DvPslxBsVMb3wWmgl9VDe2KKYSg5aUXit1qmik4nnJUMev6F4V35gRGwNLCRIODAkEA0Kj2DUhM+q9AelG6oWLWgYbQfvihPcXKpJARDH2R+EWSqBDV4H7jyjg3GB3O7nh6NyMYgq/N3CVdRPWYe40tRQJAUhe9mFtcVbhfuuphsWbSgCwSvCN6IYj11ePcgdvngumZOvnhHjUTAXoSBTVny3vqL3gunTQN8PvCTBB3XlBnQQJAGwV2b7voNCKT4ANLfvDUxItX3smF4AEIQA1kF9D/IT6pQliDygHEsABdqiLaFGnHsfI6j1oC97pi/LYtW/qpXQJAC0UhKuyOY2iPqXtknpQSmjEDufemfOAZP9Rf1GQU1FXcHgnVos88npbbsMkEWNgtjCxdT2WbADbxM/S96BPSDg==",
            //异步通知地址
            'notify_url' => "http://mobile2.cf8.cn/pay.php?code=alipayweb",
            //同步跳转
            'return_url' => "http://i.cf8.com.cn/pay.php?mod=pay",
            //编码格式
            'charset' => "UTF-8",
            //签名方式
            'sign_type'=>"RSA",
            //支付宝网关
            'gatewayUrl' => "https://openapi.alipay.com/gateway.do",
            //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
            'alipay_public_key' => 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDDI6d306Q8fIfCOaTXyiUeJHkrIvYISRcc73s3vF1ZT7XN8RNPwJxo8pWaJMmvyTn9N4HQ632qJBVHf8sxHi/fEsraprwCtzvzQETrNRwVxLO5jVmRGi60j8Ue1efIlzPXV9je9mkjzOmdssymZkh2QhUrCmZYI/FCEa3/cNMW0QIDAQAB',
        );


    /**
     * 发起支付
     * @param int   $order_id       订单号
     * @param float $price          订单价格,两位小数
     * @param int   $uid            用户UID
     * @return bool|web\提交表单HTML文本|mixed|\SimpleXMLElement|string       返回一段HTML文字
     * @throws \Exception
     */
    public static function buildPay($order_id, $price, $uid)
    {
        $biz_content_arr = ["product_code" => self::PAY_PRODUCT_CODE,
                            "out_trade_no" => strval($order_id),
                            "subject" => "{$uid}充值{$price}赢家币",
                            "total_amount" => "{$price}",
                            "body" => "{$uid}充值{$price}赢家币",
        ];
        $biz_content = json_encode($biz_content_arr);

        $request = new AlipayTradePagePayRequest();

        $request->setNotifyUrl(self::$config['notify_url']);
        $request->setReturnUrl(self::$config['return_url']);
        $request->setBizContent($biz_content);

        $aop = new AopClient ();
        $aop->gatewayUrl = self::$config['gatewayUrl'];
        $aop->appId = self::$config['app_id'];
        $aop->rsaPrivateKey =  self::$config['merchant_private_key'];
        $aop->alipayrsaPublicKey =  self::$config['alipay_public_key'];
        $aop->apiVersion = self::PAY_VERSION;
        $aop->postCharset = self::$config['charset'];
        $aop->format= self::PAY_FORAMT;
        $aop->signType= self::$config['sign_type'];
        // 开启页面信息输出
        $ispage = true;
        if($ispage){
            $result = $aop->pageExecute($request,"post");
        } else {
            $result = $aop->Execute($request);
        }

        return $result;
    }
}