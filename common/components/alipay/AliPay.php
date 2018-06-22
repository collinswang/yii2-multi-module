<?php
/**
 *
 * User: cf8
 * Date: 18-6-22
 */

namespace common\components\alipay;


use common\components\alipay\lib\AlipayNotify;
use common\modules\finance\data\FinanceIncomeData;
use common\modules\finance\service\FinanceIncomeService;

class AliPay
{
    //支付宝配置信息
    private static $config = [
        //合作身份者ID，签约账号，以2088开头由16位纯数字组成的字符串，查看地址：https://openhome.alipay.com/platform/keyManage.htm?keyType=partner
        'partner' => '',
        //商户的私钥,此处填写原始私钥去头去尾，RSA公私钥生成：https://doc.open.alipay.com/doc2/detail.htm?spm=a219a.7629140.0.0.nBDxfy&treeId=58&articleId=103242&docType=1
        'private_key'=> '',
        //支付宝的公钥，查看地址：https://openhome.alipay.com/platform/keyManage.htm?keyType=partner
        'alipay_public_key' => 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDDI6d306Q8fIfCOaTXyiUeJHkrIvYISRcc73s3vF1ZT7XN8RNPwJxo8pWaJMmvyTn9N4HQ632qJBVHf8sxHi/fEsraprwCtzvzQETrNRwVxLO5jVmRGi60j8Ue1efIlzPXV9je9mkjzOmdssymZkh2QhUrCmZYI/FCEa3/cNMW0QIDAQAB',
        //异步通知接口
        'service'   =>  'mobile.securitypay.pay',
        //签名方式 不需修改
        'sign_type'  =>  'RSA',
        //字符编码格式 目前支持 gbk 或 utf-8
        'input_charset'  =>  'utf-8',
        //ca证书路径地址，用于curl中ssl校验
        //请保证cacert.pem文件在当前文件夹目录中
        'cacert'  =>  './cacert.pem',
        //访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
        'transport'  =>  'http',
        //支付成功回调地址
        //'notify_url'  =>  'http://mobile2.cf8.cn/pay.php?code=alipay',
    ];

    /**
     * 生成APP用链接
     * @param     $income_id
     * @param int $price
     * @param int $uid
     * @param     $notify_url
     * @return string
     */
    public static function build_app($income_id, $price = 0, $uid = 0, $notify_url)
    {
        $alipay_config = self::$config;
        require_once(__DIR__."/lib/alipay_rsa.function.php");
        require_once(__DIR__."/lib/alipay_core.function.php");

        //确认PID和接口名称是否匹配。
        date_default_timezone_set("PRC");
        //将post接收到的数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串。

        // 签约合作者身份ID
//        $orderInfo['partner'] = $alipay_config['partner'];
//        $orderInfo['seller_id'] = $alipay_config['partner'];
//        $orderInfo['out_trade_no'] = ($uid+time()).rand(1,99);
//        $orderInfo['subject'] = "赢家币";
//        $orderInfo['body'] = "{$price}赢家币";
//        $orderInfo['total_fee'] = $price;   //分
//        $orderInfo['notify_url'] = urlencode("http://mobile2.cf8.cn/fin/i_fin_0803_v1&uid={$uid}&money={$price}&type=5");
//        $orderInfo['service'] = "mobile.securitypay.pay";
//        $orderInfo['payment_type'] = "1";
//        $orderInfo['it_b_pay'] = "30m";
//        $orderInfo['_input_charset'] = "utf-8";
//        $orderInfo['return_url'] = "www.cf8.com.cn";

        $orderInfo['partner'] = $alipay_config['partner'];
        $orderInfo['seller_id'] = $alipay_config['partner'];
        $orderInfo['out_trade_no'] = $income_id;
        $orderInfo['subject'] = "金币";
        $orderInfo['body'] = "{$uid}充值{$price}金币";
        $orderInfo['total_fee'] = $price;
        $orderInfo['notify_url'] = urlencode($notify_url.'?code=alipay');
        $orderInfo['service'] = $alipay_config['service'];
        $orderInfo['payment_type'] = "1";
        $orderInfo['it_b_pay'] = "30m";
        $orderInfo['_input_charset'] = "utf-8";
        $orderInfo['return_url'] = "www.alipay.com";

        //除去待签名参数数组中的空值和签名参数
        $orderInfo = paraFilter($orderInfo);

        //对待签名参数数组排序
        $orderInfo = argSort($orderInfo);
        $data=createLinkstring($orderInfo);

        //将待签名字符串使用私钥签名,且做urlencode. 注意：请求到支付宝只需要做一次urlencode.
        $rsa_sign = rsaSign($data, $alipay_config['private_key']);
        $rsa_sign_encode=urlencode($rsa_sign);

        //把签名得到的sign和签名类型sign_type拼接在待签名字符串后面。
        $data_str = $data.'&sign="'.$rsa_sign_encode.'"&sign_type="'.$alipay_config['sign_type'].'"';

        //返回给客户端,建议在客户端使用私钥对应的公钥做一次验签，保证不是他人传输。
        return $data_str;
    }

    /**
     * 支付回调
     * @return string
     */
    public static function response_alipay()
    {
        $config = self::$config;
        //计算得出通知验证结果
        $alipayNotify = new AlipayNotify($config);
        if($alipayNotify->getResponse($_POST['notify_id']))//判断成功之后使用getResponse方法判断是否是支付宝发来的异步通知。
        {
            unset($_POST['r']);
            unset($_POST['code']);
            $_POST['sign'] = str_replace(' ', '+', $_POST['sign']);
            $out_trade_no = intval($_POST['out_trade_no']);    //商户订单号
            $trade_no = $_POST['trade_no'];         //支付宝交易号
            $trade_status = $_POST['trade_status']; //交易状态
            $total_fee = $_POST['total_fee'];	//交易金额
            //$partner = $_POST['partner'];	//商户号
            $seller_id = $_POST['seller_id'];	//商户号
            if ($seller_id == $config['partner'] && ($trade_status == 'TRADE_FINISHED' || $trade_status == 'TRADE_SUCCESS')) {
                //校验成功,入库
                return self::check_update_order($out_trade_no, $total_fee, $trade_no);
            } else {
                return "verify fail";
            }
        }
        else //验证是否来自支付宝的通知失败
        {
            return "response fail";
        }
    }

    /**
     * 检查并更新订单
     * @param $order_id
     * @param $total_fee
     * @param $trade_no
     * @return string
     */
    private static function check_update_order($order_id, $total_fee, $trade_no)
    {
        $income_model = new FinanceIncomeService();
        $order = $income_model->getOne($order_id);
        if ($order && $total_fee == $order['payable']) {
            //校验成功,入库
            $income_model->update($order_id, FinanceIncomeData::STATUS_SUCCESS, 0, "$trade_no");
            return "success";
        } else {
            return "verify fail";
        }
    }
}