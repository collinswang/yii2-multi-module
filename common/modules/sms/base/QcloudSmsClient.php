<?php
/**
 * 短信发送模块
 */

namespace common\modules\sms\base;


use Qcloud\Sms\SmsMobileStatusPuller;
use Qcloud\Sms\SmsMultiSender;
use Qcloud\Sms\SmsSingleSender;
use Qcloud\Sms\SmsStatusPuller;
use Yii;

class QcloudSmsClient implements SmsInterface
{
    /**
     * @param mixed $appid
     */
    public static $template_type = [0=>'普通短信模板', 1 =>'营销短信模板', 2 => '语音模板'];
    const TEMPLATE_TYPE_NORMAL = 0;
    const TEMPLATE_TYPE_SPREAD = 1;
    const TEMPLATE_TYPE_VOICE = 2;

    private $appid;
    private $appkey;

    public function __construct()
    {
        $this->appid = Yii::$app->params['qcloud_sms']['appid'];
        $this->appkey = Yii::$app->params['qcloud_sms']['appkey'];
    }

    /**
     * 单次发送模板短信
     * @link    https://cloud.tencent.com/document/product/382/5976
     * @param string $mobile 手机号列表
     * @param int    $tpl_id 远程平台模板ID
     * @param array  $data   模板内对应参数表
     * @return mixed
     *     {
     *     "result": 0,
     *     "errmsg": "OK",
     *     "ext": "",
     *     "fee": 1,
     *     "sid": "xxxxxxx"
     *     }
     */
    public function smsSendTemplateMsgSingle($mobile, $tpl_id, $data)
    {
        $single_send = new SmsSingleSender($this->appid, $this->appkey);

        $nationCode = "86";
        $sign ="";
        $extend = "";
        $ext = "";
        $result = $single_send->sendWithParam($nationCode, $mobile, $tpl_id, $data, $sign, $extend, $ext);

        return json_decode($result, true);
    }

    /**
     * 批量发送模板短信
     * @param array     $mobiles    手机号列表
     * @param int       $tpl_id     远程平台模板ID
     * @param array     $params     模板内对应参数表
     * @return mixed
     */
    public function smsSendTemplateMsgBatch($mobiles, $tpl_id, $params)
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
    public function smsSendMsgSingle($mobile, $content, $type)
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
    public function smsSendMsgBatch($mobiles, $content, $type)
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
    public function smsSendCallback($type, $max)
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
    public function smsReplyMsg($mobile, $start_time, $end_time, $max = 100)
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
    public function smsSendStatus($mobile, $start_time, $end_time, $max = 100)
    {
        $nationCode = "86";
        $mspuller = new SmsMobileStatusPuller($this->appid, $this->appkey);

        // 拉取短信回执
        $callbackResult = $mspuller->pullCallback($nationCode, $mobile, $start_time, $end_time, $max);
        $result = json_decode($callbackResult, true);

        return $result;
    }
}