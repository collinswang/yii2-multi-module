<?php
/**
 * 短信发送模块
 */

namespace common\modules\sms\base;


use Qcloud\Sms\SmsSenderUtil;
use Yii;

class QcloudSmsClient implements SmsInterface
{
    const ADD_URL = 'https://yun.tim.qq.com/v5/tlssmssvr/add_template';
    const UPDATE_URL = 'https://yun.tim.qq.com/v5/tlssmssvr/mod_template';
    const DELETE_URL = 'https://yun.tim.qq.com/v5/tlssmssvr/del_template';
    const CHECK_URL = 'https://yun.tim.qq.com/v5/tlssmssvr/get_template';

    /**
     * @param mixed $appid
     */
    public static $template_type = [0=>'普通短信模板', 1 =>'营销短信模板', 2 => '语音模板'];
    const TEMPLATE_TYPE_NORMAL = 0;
    const TEMPLATE_TYPE_SPREAD = 1;
    const TEMPLATE_TYPE_VOICE = 2;

    private $url;
    private $appid;
    private $appkey;
    private $util;

    public function __construct()
    {
        $this->appid = Yii::$app->params['qcloud_sms']['appid'];
        $this->appkey = Yii::$app->params['qcloud_sms']['appkey'];
        $this->util = new SmsSenderUtil();
    }

    /**
     * 单次发送模板短信
     * @return mixed
     */
    public function sms_send_template_msg_single()
    {
        $this->url = self::ADD_URL;
        $random = $this->util->getRandom();
        $curTime = time();
        $wholeUrl = $this->url . "?sdkappid=" . $this->appid . "&random=" . $random;

        // 按照协议组织 post 包体
        $data['params'] = $params;      //必填，array，模板参数，若模板没有参数，请提供为空数组
        $data['time'] = $curTime;   //必填，请求发起时间，unix 时间戳，如果和QQ服务器系统时间相差超过 10 分钟则会返回失败
        $data['title'] = $title;    //可选，模板名称
        $data['remark'] = $desc;    //可选，模板备注，比如申请原因，使用场景等
        $data['ext'] = $ext;        //可选，用户的 session 内容，腾讯 server 回包中会原样返回，可选字段，不需要就填空
        $data['extend'] = "";       //可选，短信码号扩展号，格式为纯数字串，其他格式无效。默认没有开通，开通请联系腾迅
        $data['sig'] = hash("sha256", "appkey=".$this->appkey."&random=".$random."&time=".$curTime, FALSE);

        $result = $this->util->sendCurlPost($wholeUrl, $data);
        return json_decode($result, true);
    }

    /**
     * 批量发送模板短信
     * @return mixed
     */
    public function sms_send_template_msg_batch()
    {

    }

    /**
     * 单次发送短信
     * @return mixed
     */
    public function sms_send_msg_single()
    {

    }

    /**
     * 批量发送短信
     * @return mixed
     */
    public function sms_send_msg_batch()
    {

    }

    /**
     * 短信发送结果回调
     * @return mixed
     */
    public function sms_send_callback()
    {

    }

    /**
     * 获取短信回复
     * @return mixed
     */
    public function sms_reply_msg()
    {

    }

    /**
     * 短信发送结果
     * @return mixed
     */
    public function sms_send_status()
    {

    }
}