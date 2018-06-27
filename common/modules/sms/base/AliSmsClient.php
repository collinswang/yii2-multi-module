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
        0 => "云提醒",
    ];

    public static $template = [
        0 => ["id" => "SMS_137672391", "content" => '您订购的${product}已发货，${express}单号${expressNo}，请注意查收！'],   //发货模板
        1 => ["id" => "SMS_116780131", "content" => '验证码${code}，您正在登录，若非本人操作，请勿泄露。'],
    ];

    public function __construct()
    {
        $this->appid = Yii::$app->params['ali_sms']['appid'];
        $this->appkey = Yii::$app->params['ali_sms']['appkey'];
    }

    /**
     * 单次发送模板短信
     * @link    https://cloud.tencent.com/document/product/382/5976
     * @param string $mobile 手机号列表
     * @param int    $tpl_id 远程平台模板ID
     * @param array  $params   模板内对应参数表    K=>v
     * @return mixed
     *     {
     *     "result": 0,
     *     "errmsg": "OK",
     *     "ext": "",
     *     "fee": 1,
     *     "sid": "xxxxxxx"
     *     }
     */
    public function smsSendTemplateMsgSingle($mobile, $tpl_id, $params)
    {
        $data = array ();

        // fixme 必填: 短信接收号码
        $data["PhoneNumbers"] = "$mobile";

        // fixme 必填: 短信签名，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
        $data["SignName"] = self::$sign[0];

        // fixme 必填: 短信模板Code，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
        $data["TemplateCode"] = $tpl_id;

        // fixme 可选: 设置模板参数, 假如模板中存在变量需要替换则为必填项
        $data['TemplateParam'] = $params;

        // fixme 可选: 设置发送短信流水号
        $data['OutId'] = "";

        // fixme 可选: 上行短信扩展码, 扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段
        $data['SmsUpExtendCode'] = "";

        // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
        if(!empty($data["TemplateParam"]) && is_array($data["TemplateParam"])) {
            $data["TemplateParam"] = json_encode($data["TemplateParam"], JSON_UNESCAPED_UNICODE);
        }

        // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
        $helper = new SignatureHelper();

        // 此处可能会抛出异常，注意catch
        $content = $helper->request(
            $this->appid,
            $this->appkey,
            array_merge($data, array(
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
    public function smsSendTemplateMsgBatch($mobiles, $tpl_id, $params)
    {
        $data = array ();

        //必填: 短信接收号码
        $data["PhoneNumbers"] = $mobiles;

        // fixme 必填: 短信签名，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
        $data["SignName"] = self::$sign[0];

        // fixme 必填: 短信模板Code，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
        $data["TemplateCode"] = $tpl_id;

        // fixme 可选: 设置模板参数, 假如模板中存在变量需要替换则为必填项
        $data['TemplateParam'] = $params;

        // fixme 可选: 设置发送短信流水号
        $data['OutId'] = "";

        // fixme 可选: 上行短信扩展码, 扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段
        $data['SmsUpExtendCode'] = "";

        // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
        if(!empty($data["TemplateParam"]) && is_array($data["TemplateParam"])) {
            $data["TemplateParam"] = json_encode($data["TemplateParam"], JSON_UNESCAPED_UNICODE);
        }

        // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
        $helper = new SignatureHelper();

        // 此处可能会抛出异常，注意catch
        $content = $helper->request(
            $this->appid,
            $this->appkey,
            array_merge($data, array(
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
     * 单次发送短信
     * @param string     $mobile    手机号列表
     * @param string    $content    短信内容
     * @param int       $type       短信类型，0 为普通短信，1 营销短信
     * @return mixed
     */
    public function smsSendMsgSingle($mobile, $content, $type)
    {

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

    }

    /**
     * 获取短信发送结果回调(队列式，同一条短信只返回一次数据)
     * @param int   $type   0: 短信下发状态, 1: 短信回复
     * @param $max
     * @return mixed
     */
    public function smsSendCallback($type, $max)
    {

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

    }
}