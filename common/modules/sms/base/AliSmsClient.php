<?php
/**
 * 短信发送模块
 */

namespace common\modules\sms\base;


use common\components\alisms\SignatureHelper;
use Yii;

class AliSmsClient implements SmsInterface
{
    private $appid;
    private $appkey;

    public static $sign = [
        0 => "阿里云短信测试专用",
    ];

    public static $template = [
        0 => ["id" => "SMS_0000001", "content" => "阿里云短信测试专用"],
    ];

    public function __construct()
    {
        $this->appid = Yii::$app->params['ali_sms']['appid'];
        $this->appkey = Yii::$app->params['ali_sms']['appkey'];
    }

    /**
     * 单次发送模板短信
     * @link    https://cloud.tencent.com/document/product/382/5976
     * @param string    $mobile     手机号列表
     * @param int       $tpl_id     远程平台模板ID
     * @param array     $params     模板内对应参数表
     * @return mixed
     *     {
     *     "result": 0,
     *     "errmsg": "OK",
     *     "ext": "",
     *     "fee": 1,
     *     "sid": "xxxxxxx"
     *     }
     */
    public function sms_send_template_msg_single($mobile, $tpl_id, $params)
    {
        $params = array ();

        // fixme 必填: 短信接收号码
        $params["PhoneNumbers"] = "$mobile";

        // fixme 必填: 短信签名，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
        $params["SignName"] = self::$sign[0];

        // fixme 必填: 短信模板Code，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
        $params["TemplateCode"] = self::$template[$tpl_id];

        // fixme 可选: 设置模板参数, 假如模板中存在变量需要替换则为必填项
        $params['TemplateParam'] = Array (
            "code" => "12345",
            "product" => "阿里通信"
        );

        // fixme 可选: 设置发送短信流水号
        $params['OutId'] = "12345";

        // fixme 可选: 上行短信扩展码, 扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段
        $params['SmsUpExtendCode'] = "1234567";


        // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
        if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
            $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
        }

        // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
        $helper = new SignatureHelper();

        // 此处可能会抛出异常，注意catch
        $content = $helper->request(
            $this->appid,
            $this->appkey,
            array_merge($params, array(
                "RegionId" => "cn-hangzhou",
                "Action" => "SendSms",
                "Version" => "2017-05-25",
            ))
        // fixme 选填: 启用https
        // ,true
        );

        return $content;
    }

    /**
     * 批量发送模板短信
     * @param array     $mobiles    手机号列表
     * @param int       $tpl_id     远程平台模板ID
     * @param array     $params     模板内对应参数表
     * @return mixed
     */
    public function sms_send_template_msg_batch($mobiles, $tpl_id, $params)
    {
        $multi_send = new SmsMultiSender($this->appid, $this->appkey);

        $nationCode = "86";
        $sign ="";
        $extend = "";
        $ext = "";
        $result = $multi_send->sendWithParam($nationCode, $mobiles, $tpl_id, $params, $sign, $extend, $ext);

        return json_decode($result, true);
    }

    /**
     * 单次发送短信
     * @param string     $mobile    手机号列表
     * @param string    $content    短信内容
     * @param int       $type       短信类型，0 为普通短信，1 营销短信
     * @return mixed
     */
    public function sms_send_msg_single($mobile, $content, $type)
    {
        $single_send = new SmsSingleSender($this->appid, $this->appkey);

        $nationCode = "86";
        $extend = "";
        $ext = "";
        $result = $single_send->send($type, $nationCode, $mobile, $content, $extend, $ext);

        return json_decode($result, true);
    }

    /**
     * 批量发送短信
     * @param array     $mobiles    手机号列表
     * @param string    $content    短信内容
     * @param int       $type       短信类型，0 为普通短信，1 营销短信
     * @return mixed
     */
    public function sms_send_msg_batch($mobiles, $content, $type)
    {
        $multi_send = new SmsMultiSender($this->appid, $this->appkey);

        $nationCode = "86";
        $extend = "";
        $ext = "";
        $result = $multi_send->send($type, $nationCode, $mobiles, $content, $extend, $ext);

        return json_decode($result, true);
    }

    /**
     * 获取短信发送结果回调(队列式，同一条短信只返回一次数据)
     * @param int   $type   0: 短信下发状态, 1: 短信回复
     * @param $max
     * @return mixed
     */
    public function sms_send_callback($type, $max)
    {
        $spuller = new SmsStatusPuller($this->appid, $this->appkey);

        if($type == 1){
            // 拉取短信回复
            $callbackResult = $spuller->pullReply(10);
        } else {
            // 拉取短信发送结果
            $callbackResult = $spuller->pullCallback(10);
        }
        $result = json_decode($callbackResult, true);

        return $result;
    }

    /**
     * 获取单个手机短信回复
     * @param     $mobile
     * @param     $start_time
     * @param     $end_time
     * @param int $max
     * @return mixed
     */
    public function sms_reply_msg($mobile, $start_time, $end_time, $max = 100)
    {
        $nationCode = "86";
        $mspuller = new SmsMobileStatusPuller($this->appid, $this->appkey);

        // 拉取短信回执
        $callbackResult = $mspuller->pullReply($nationCode, $mobile, $start_time, $end_time, $max);
        $result = json_decode($callbackResult, true);

        return $result;
    }

    /**
     * 短信单个手机发送结果
     * @param     $mobile
     * @param     $start_time
     * @param     $end_time
     * @param int $max
     * @return mixed
     */
    public function sms_send_status($mobile, $start_time, $end_time, $max = 100)
    {
        $nationCode = "86";
        $mspuller = new SmsMobileStatusPuller($this->appid, $this->appkey);

        // 拉取短信回执
        $callbackResult = $mspuller->pullCallback($nationCode, $mobile, $start_time, $end_time, $max);
        $result = json_decode($callbackResult, true);

        return $result;
    }
}