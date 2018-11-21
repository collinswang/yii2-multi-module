<?php

namespace frontend\controllers;

use common\components\wxpay\WxPay;
use common\modules\finance\data\FinanceIncomeData;
use common\modules\finance\service\FinanceIncomeService;

/**
 * FinanceController implements the CRUD actions for FinanceFlow model.
 */
class PaymentController extends \yii\web\Controller
{

    /**
     * 支付返回验证
     * @param string    $code   alipay=支付宝  wechat=微信   kuai=快钱
     * @return string
     * @example
     *      http://mobile2.cf8.cn/?r=payment/i_payment_01_v1/feedback&code=alipay
     */
    public function actionFeedback($code)
    {
        switch ($code) {
            case 'alipay':
                $result = $this->_response_alipay();
                break;
            default:    //华讯接口微信支付回调
                $result = $this->_response_wechat();
                break;
        }
        return $result;
    }

    /**
     * 支付宝支付成功回调
     * @return string
     */
    public function _response_alipay()
    {
        require_once(__DIR__."/../../common/components/alipay/alipay.config.php");
        require_once(__DIR__."/../../common/components/alipay/lib/alipay_notify.class.php");

        //计算得出通知验证结果
        $alipayNotify = new AlipayNotify($alipay_config);
        if($alipayNotify->getResponse($_POST['notify_id']))//判断成功之后使用getResponse方法判断是否是支付宝发来的异步通知。
        {
            unset($_POST['r']);
            unset($_POST['code']);
            $_POST['sign'] = str_replace(' ', '+', $_POST['sign']);
            $out_trade_no = intval($_POST['out_trade_no']);    //商户订单号
            $trade_no = $_POST['trade_no'];         //支付宝交易号
            $trade_status = $_POST['trade_status']; //交易状态
            $total_fee = $_POST['total_fee'];	//交易金额
            $partner = $_POST['partner'];	//商户号
            $seller_id = $_POST['seller_id'];	//商户号
            //检查订单是否存在
            $model = new FinanceIncomeService();
            $orderinfo = $model->getOne($out_trade_no);
            if ($orderinfo && $total_fee == $orderinfo['payable'] && $seller_id == $alipay_config['partner'] && ($trade_status == 'TRADE_FINISHED' || $trade_status == 'TRADE_SUCCESS')) {
                //校验成功,入库
                $result = $model->update($out_trade_no, FinanceIncomeData::STATUS_SUCCESS, 0, "$trade_no");
                return "success";
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
     * 微信支付支付成功回调
     * @return string
     */
    public function _response_wechat()
    {
        $result = WxPay::respond();
        if ($result['status']){
            $return = "<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>";
        }else{
            $return = "<xml><return_code><![CDATA[FAIL]]></return_code><return_msg><![CDATA[FAIL]]></return_msg></xml>";
        }
        return $return;
    }

}
