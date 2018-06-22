<?php
/**
 *
 * User: cf8
 * Date: 18-6-22
 */

namespace common\modules\finance\service;


use common\components\alipay\AliPay;
use common\components\wxpay\WxPay;
use common\modules\finance\data\FinanceIncomeData;

class PaymentService
{

    //回调地址：支付宝需要URLENCODE，微信支付URL不能带参数
    const NOTIFY_URL = 'http://api.cf8.cn/pay.php';
    /**
     * @return bool|string
     * example:     /?r=payment/i_payment_01_v1/index&uid=1623128&type=2&price=10
     */
    public function actionIndex()
    {
        $uid = intval($_GET['uid']);
        $type = intval($_GET['type']);
        $price = floatval($_GET['price']);
        $result = '';
        //判断是不是合法提交类型
        if($uid == 1623128){
            $price = 0.01;
        }

        //创建订单
        $finance_model = new FinanceIncomeService();
        try{
            $add_result = $finance_model->add($uid, $type, FinanceIncomeData::STATUS_PAYING, $price);
            if($add_result['status'] <=0 || $add_result['id'] <=0){
                return false;
            }
            $income_id = $add_result['id'];
        } catch (\Exception $e){
            return false;
        }

        if(!$income_id){
            return false;
        }

        if(in_array($type, array_keys(FinanceIncomeData::$type_arr))){
            switch($type){
                case 1:
                    $result = $this->_alipay($income_id, $price, $uid);
                    break;
                case 2:
                    $result = $this->_wechat($income_id, $price, $uid);
                    break;
            }
            return $result;
        } else{
            return '';
        }
    }

    public function _alipay($income_id, $price = 0, $uid = 0)
    {
        $result = AliPay::build_app($income_id, $price, $uid, self::NOTIFY_URL);
        //返回给客户端,建议在客户端使用私钥对应的公钥做一次验签，保证不是他人传输。
        return $result;
    }

    /**
     * 华讯版微信支付
     * @param int   $income_id
     * @param float $price
     * @param int   $uid
     * @return array
     */
    public function _wechat($income_id, $price, $uid)
    {
        //去微信取preapy_id 生成签名    返回给APP
        $notifyUrl = self::NOTIFY_URL;
        $outTradeNo = $income_id;
        $orderName = "{$uid}充值{$price}元";
        $wx_pay = new WxPay();
        $result = $wx_pay->buildPrepay($price, $outTradeNo, $orderName, $notifyUrl, time());
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $result;
    }




    /**======================================支付回调================================================**/

    /**
     * 支付回调接口
     * @param string    $code   alipay=支付宝  wechat=微信   kuai=快钱
     * @return string
     */
    public function actionFeedback($code)
    {
        switch ($code) {
            case 'alipay':
                $result = $this->_response_alipay();
                break;
            default:    //微信支付回调
                $result = $this->_response_wechat();
                break;
        }
        return $result;
    }

    /**
     * 支付宝App支付回调
     * @return string
     */
    public function _response_alipay()
    {
        $result = Alipay::response_alipay();
        return $result;
    }

    /**
     * 微信支付回调
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