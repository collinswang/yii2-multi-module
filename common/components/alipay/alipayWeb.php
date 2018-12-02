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
            'app_id' => "2018092461536281",
            //商户私钥
            'merchant_private_key' => 'MIIEowIBAAKCAQEAvFk/cN2TiOG0z4s0wdcOd+Li5zwj+H+3qg8s2GxtDAMZfuS2mCdMOvxxV/6DHvth5+kUgWpkV7VbNw9FxgbgABPUFygGSAhu8ldzVSspF55nI1Se/iFDffTsEYG+U1v7ZqF87ojycxEVGJd9u1MBN8oImM/nHvHmHGo4hRVEGGocT+RVWKcnG5Xdghz24Uyn/idTyRA7ZUkd9HapFcNF03hwPeRFYuuNJSoQgFwlN8n/Km/LOThbKnxaLEfTMytTgyzB9UYbclQagLTfSZQyCYfiZKPGrjEKX8LeRBC8+T17mVHITZD+1EBYQ2JuO4LaJFKYgMCZ4rSDr4mbE23q7wIDAQABAoIBACyb7ryqniDTZGGrlMk8SD74y8j8o4Bdr4Blq7dupr0rlsRJIz4SQKnP1ICE1UVnQJ8Owz6Llkx3tazqvxnR0wfxqk/5uNMivDRFphlL6aWgbMkfZ7DE7BlPAwJ6ejuAE6ERKmfMo6/BIf/7EVpmpGk0PqkCxLi9jkS4m75ZdRFa1+KxiGhkKdIS+hJDUpIxsvU0ttZsNxB1GibPg0KRFsbs7Qhx7q6DhNFr2acj/j52vUMpCTN+S94I9jjJZttoqAuAh22psB4nfK86rQ/jMd078B26SElIeM4G3Hq9ZSVpa4cliJr+1hI0gtSdHv3LnpQWRNdJoVgJ9938nlM+XNECgYEA8tgaypaiu9SM5UfG/DchnwBn+Pb+H+gq9HXvLLalIrGP5cvZzjn3/tNiucer15r9ssqhqCmzeWplkXhiRPSdnV4xC38Q7X8POYye11tldtZRl3kUvW+O6kfrsb/nT6upBe7uoqXceIFOPbb0PpLn1NySq7SNk4j2gTIhZnAJFpUCgYEAxo1ejVT9r8BXozQ1509rs1iYRCx/27/xjkQmilsnWdrlRqNFsFD+DmtdRdl7Z5j0nG56lDEjt59akJlALCpO+3G7HKXBG3skgZSrc0F3b2zoKS56yGcHKId4AKb2qgyF9qmLju+W88ClS+jB6OPFd3sPoq/KhDp7vle6y8eiLnMCgYBhCsSiAlIjdwuar/UvYqSX0mS6E5F3lKJdsCcUmiQhWg1jyfNOutGETlqcXNMpxHDvGpRBC/EBaugNmqrCXXICqdo1euB715Nw7uWmr4o7U+ek/SixjrvwmS7xh/taVgGkMlfAPUF+EkX+2XZ+7tufr0kZPnx44XmIJU09jzXChQKBgQCHuuJ1GTGm8IS4Y5upuYg1fQ3yJL1u+qLljz8Ne8zFxzbO+BROuL9EGi8T7d1Hb69gNMIFBiaVgxEFIk5VIsMFbrTrm4AMCj1le71Mt+cuu7NlW4nB73RcR2dIgtrCWndFrJdjqfN2RC57Wu0cCIDX8b85hpSZmeU3tH9UiO8ccwKBgH+r8q9dzW+oo5SASvXjgz50XmGHR5WIJYc+VMBjc/gTVXDX2cGroYVJwC5tPZWM/Xwk29pSwUJQb7I+l3nx2iFtpYfumOej8SAPWuuodT8DAYe7f0l/uekkTk7DV38JFEf4XdKKT+GcZwBSNnB8DWMAUsKNqDa7cAFuYHrbDVtp',
            //异步通知地址
            'notify_url' => "http://wintine.com/pay.php?code=alipayweb",
            //同步跳转
            'return_url' => "http://wintine.com/index.php?r=user/index",
            //编码格式
            'charset' => "UTF-8",
            //签名方式
            'sign_type'=>"RSA2",
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