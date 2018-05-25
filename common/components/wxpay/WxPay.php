<?php
/**
 * 微信支付接口
 * User: collins
 * Date: 17-5-11
 * Time: 下午1:32
 */

namespace common\components\wxpay;


use common\components\Tools;
use common\modules\cfinance\components\FuncCoin;

class WxPay
{
    const WECHAT_PREPAY_URL = "https://api.mch.weixin.qq.com/pay/unifiedorder";

    //华讯投资
    const MCHID = "";   //商户号1486605602
    const APPID = "";   //APPID
    const APPKEY = "";  //APP KEY

    /**
     * 调用该接口在微信支付服务后台生成预支付交易单，返回正确的预支付交易回话标识后再在APP里面调起支付
     * @param int    $totalFee   充值金额，单位：元
     * @param string $outTradeNo 本地唯一订单号
     * @param string $orderName  订单名称
     * @param string $notifyUrl  回调URL
     * @param int    $timestamp
     * @param int    $type      1:华讯KEY     0：点石KEY
     * @return array
     */
    public function buildPrepay($totalFee, $outTradeNo, $orderName, $notifyUrl, $timestamp, $type=1)
    {
        //echo "==$totalFee, $outTradeNo, $orderName, $notifyUrl, $timestamp==";
        $nonce_str = self::createNonceStr();
        $ip = Tools::get_ip();
        $ip = $ip ? $ip : "127.0.0.1";
        $appid = self::APPID;
        $mchid = self::MCHID;
        $appkey = self::APPKEY;
        $unified = array(
            'appid' => $appid,
            'body' => $orderName,
            'mch_id' => $mchid,
            'nonce_str' => $nonce_str,
            'notify_url' => $notifyUrl,
            'out_trade_no' => $outTradeNo,
            'spbill_create_ip' => $ip,
            'total_fee' => round($totalFee * 100),
            'trade_type' => 'APP',
        );
        $unified['sign'] = self::getSign($unified, $appkey);
        $responseXml = self::curlPost(self::WECHAT_PREPAY_URL, self::arrayToXml($unified));
        $unifiedOrder = simplexml_load_string($responseXml, 'SimpleXMLElement', LIBXML_NOCDATA);
        if ($unifiedOrder === false) {
            return array('status'=>0, 'msg'=> '请求失败');
        }
        $check_status = self::checkSign($unifiedOrder, $appkey);
        if(false === $check_status){
            return array('status'=>0, 'msg'=> '签名验证失败');
        }
        if ($unifiedOrder->return_code != 'SUCCESS') {
            return array('status'=>0, 'msg'=> $unifiedOrder->return_msg);
        }

        $arr = array(
            "prepay_id" => "" . $unifiedOrder->prepay_id,
            'orderNo' => $outTradeNo,
            'notifyUrl' => $notifyUrl,
            "timeStamp" => $timestamp,
            "nonceStr" => $nonce_str,
        );
        $arr['paySign'] = self::getSign($arr, $appkey);
        return array('status'=>1, 'msg'=> '成功', 'code'=> $arr);
    }

    /**
     * TODO 调用该接口在微信支付服务后台生成预支付交易单，返回正确的预支付交易回话标识后再在WEB页面显示二维码
     * @param int    $totalFee   充值金额，单位：元
     * @param string $outTradeNo 本地唯一订单号
     * @param string $orderName  订单名称
     * @param string $notifyUrl  回调URL
     * @param int    $timestamp
     * @param int    $type      1:华讯KEY     0：点石KEY
     * @return array
     */
    public function buildPrepayWeb($totalFee, $outTradeNo, $orderName, $notifyUrl, $timestamp, $type=1)
    {
        //echo "==$totalFee, $outTradeNo, $orderName, $notifyUrl, $timestamp==";
        $nonce_str = self::createNonceStr();
        $ip = Tools::get_ip();
        $ip = $ip ? $ip : "127.0.0.1";
        $appid = self::APPID;
        $mchid = self::MCHID;
        $appkey = self::APPKEY;
        $unified = array(
            'appid' => $appid,
            'body' => $orderName,
            'mch_id' => $mchid,
            'nonce_str' => $nonce_str,
            'notify_url' => $notifyUrl,
            'out_trade_no' => $outTradeNo,
            'spbill_create_ip' => $ip,
            'total_fee' => intval($totalFee * 100),
            'trade_type' => 'JSAPI',
        );
        $unified['sign'] = self::getSign($unified, $appkey);
        $responseXml = self::curlPost(self::WECHAT_PREPAY_URL, self::arrayToXml($unified));
        $unifiedOrder = simplexml_load_string($responseXml, 'SimpleXMLElement', LIBXML_NOCDATA);
        if ($unifiedOrder === false) {
            return array('status'=>0, 'msg'=> '请求失败');
        }
        $check_status = self::checkSign($unifiedOrder, $appkey);
        if(false === $check_status){
            return array('status'=>0, 'msg'=> '签名验证失败');
        }
        if ($unifiedOrder->return_code != 'SUCCESS') {
            return array('status'=>0, 'msg'=> $unifiedOrder->return_msg);
        }

        $arr = array(
            "prepay_id" => "" . $unifiedOrder->prepay_id,
            'orderNo' => $outTradeNo,
            'notifyUrl' => $notifyUrl,
            "timeStamp" => $timestamp,
            "nonceStr" => $nonce_str,
        );
        $arr['paySign'] = self::getSign($arr, $appkey);
        return array('status'=>1, 'code'=> $arr);
    }

    /**
     * 参见：http://i.cf8.com.cn/wxcall.php
     * @return array
     */
    public static function respond()
    {

        $xml_arr = array();
        //获取more数据
        $morexml = file_get_contents('php://input');
        if(!$morexml){
            return ['status'=>0, 'msg'=> '无输入'];
        }
//        $morexml = "<xml><appid><![CDATA[wx6717fb2423740f7c]]></appid>
//                    <bank_type><![CDATA[ICBC_DEBIT]]></bank_type>
//                    <cash_fee><![CDATA[1]]></cash_fee>
//                    <fee_type><![CDATA[CNY]]></fee_type>
//                    <is_subscribe><![CDATA[N]]></is_subscribe>
//                    <mch_id><![CDATA[1219475301]]></mch_id>
//                    <nonce_str><![CDATA[VQ8pGR59HsucuWiO]]></nonce_str>
//                    <openid><![CDATA[otUf7t0gVBqee1NCbv5jia_JBXyY]]></openid>
//                    <out_trade_no><![CDATA[226635]]></out_trade_no>
//                    <result_code><![CDATA[SUCCESS]]></result_code>
//                    <return_code><![CDATA[SUCCESS]]></return_code>
//                    <sign><![CDATA[9F29AAA2CA3B20B2509795D5FB869EF4]]></sign>
//                    <time_end><![CDATA[20170511183120]]></time_end>
//                    <total_fee>1</total_fee>
//                    <trade_type><![CDATA[APP]]></trade_type>
//                    <transaction_id><![CDATA[4007632001201705110444412896]]></transaction_id>
//                    </xml>
//                    ";
        if ($morexml){
            $xml = simplexml_load_string($morexml, 'SimpleXMLElement', LIBXML_NOCDATA);
            $xml_arr = self::objectToArray($xml);
        }
        if(!$xml_arr){
            return ['status'=>0, 'msg'=> '返回数据格式错误'];
        }

        $orderid = intval($xml_arr['out_trade_no']);
        //验证订单号
        if($orderid<= 0 ){
            return ['status'=>0, 'msg'=> '订单ID错误'];
        }
        //验证签名
        $sign_md5 = self::checkSign($xml, self::APPKEY_HX);
        if(!$sign_md5){
            return ['status'=>0, 'msg'=> '验证签名失败'];
        }

        if($xml_arr['result_code'] !== "SUCCESS"){
            return ['status'=>0, 'msg'=> '交易结果失败'];
        }

        $order = FuncCoin::coin_income_detail($orderid);
        if($order['status'] != 1){
            return ['status'=>1, 'msg'=> '订单已经成功'];
        }

        if(($xml_arr['total_fee']/100) != $order['payable'] || $xml_arr['mch_id'] != self::MCHID_HX){
            return ['status'=>0, 'msg'=> '数据验证失败'];
        }

        $re = FuncCoin::coin_income_update($orderid, 2, 0, 0, $xml_arr['transaction_id']);
        if ($re > 0){
            return ['status'=>1, 'msg'=> '更新成功'];
        }else{
            return ['status'=>0, 'msg'=> '更新失败'];
        }
    }

    /**
     * GET请求
     * @param string $url
     * @param array  $options
     * @return mixed
     */
    public static function curlGet($url = '', $options = array())
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        if (!empty($options)) {
            curl_setopt_array($ch, $options);
        }
        //https请求 不验证证书和host
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    /**
     * HTTPS POST提交数据
     * @param string $url
     * @param string $postData
     * @param array  $options
     * @return mixed
     */
    public static function curlPost($url = '', $postData = '', $options = array()){
        if (is_array($postData)) {
            $postData = http_build_query($postData);
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); //设置cURL允许执行的最长秒数
        if (!empty($options)) {
            curl_setopt_array($ch, $options);
        }
        //https请求 不验证证书和host
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    /**
     * 创建随机字符串
     * @param int $length
     * @return string
     */
    public static function createNonceStr($length = 16){
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $str = '';
        for ($i = 0; $i<$length; $i++){
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    /**
     * 生成签名
     * @param array $params
     * @param string    $key
     * @return string
     */
    public static function getSign($params, $key){
        ksort($params, SORT_STRING);
        $unSignParaString = self::formatQueryParaMap($params, false);
        $signStr = strtoupper(md5($unSignParaString . "&key=" . $key));
        return $signStr;
    }

    /**
     * 验证签名
     * @param object    $object
     * @return int
     */
    public static function checkSign($object, $appkey)
    {
        $arr = self::objectToArray($object);
        $tenpaySign = $arr['sign'];
        unset($arr['sign']);
        $signPars = self::formatQueryParaMap($arr);
        $signPars .= "&key=" . $appkey;
        $sign = strtoupper(md5($signPars));

        return $sign == $tenpaySign;
    }

    protected static function formatQueryParaMap($paraMap, $urlEncode = false)
    {
        $buff = "";
        ksort($paraMap);
        foreach ($paraMap as $k => $v){
            if (null != $v && 'key' != $v && "null" != $v) {
                if ($urlEncode) {
                    $v = urlencode($v);
                }
                $buff .= $k . "=" . $v . "&";
            }
        }
        $reqPar = '';
        if (strlen($buff)>0) {
            $reqPar = substr($buff, 0, strlen($buff) - 1);
        }
        return $reqPar;
    }

    public static function arrayToXml($arr){
        $xml = "<xml>";
        foreach ($arr as $key => $val){
            if (is_numeric($val)) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
            }
        }
        $xml .= "</xml>";
        return $xml;
    }

    /**
     * 对象转数组
     * @param $object
     * @return array
     */
    public static function objectToArray($object)
    {
        return @json_decode(@json_encode($object),1);
//        $result = array();
//        $object = is_object($object) ? get_object_vars($object) : $object;
//        foreach ($object as $key => $val) {
//            $val = (is_object($val) || is_array($val)) ? self::objectToArray($val) : $val;
//            $result[$key] = $val;
//        }
//
//        return $result;
    }
}