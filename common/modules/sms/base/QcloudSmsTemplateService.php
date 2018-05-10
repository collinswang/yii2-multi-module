<?php
/**
 * Qcloud签名管理模块
 */
namespace common\modules\sms\base;

use Qcloud\Sms\SmsSenderUtil;
use Yii;

class QcloudSmsTemplateService implements  SmsTemplateInterface
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
     * 发送短信
     * @param int       $type       模板类型
     * @param string    $content    模板内容    {1}为您的登录验证码，请于{2}分钟内填写。如非本人操作，请忽略本短信。（其中{数字}为可自定义的内容，须从1开始连续编号，如{1}、{2}等。）
     * @param string    $desc 签名备注，比如申请原因，使用场景等，可选字段
     * @param string    $title
     * @link https://cloud.tencent.com/document/product/382/5817
     * @return array
     *                     {
     *                     "result": 0, //0表示成功，非0表示失败
     *                     "msg": "", //result非0时的具体错误信息
     *                     "data": {
     *                          "id": 123, //签名id
     *                          "text": "xxxxx", //签名内容
     *                          "status": 1, //0：已通过；1：待审核；2：已拒绝
     *                          "type": 0 //0：普通短信模板；1：营销短信模板；2：语音模板
     *                      }
     *                     }
     */
    public function sms_template_add($content, $type =0, $desc = null, $title = null)
    {
        $this->url = self::ADD_URL;
        $random = $this->util->getRandom();
        $curTime = time();
        $wholeUrl = $this->url . "?sdkappid=" . $this->appid . "&random=" . $random;

        // 按照协议组织 post 包体
        $data['text'] = $content;   //必填，模板内容
        $data['type'] = $type;      //必填，0：普通短信模板；1：营销短信模板；2：语音模板
        $data['time'] = $curTime;   //必填，请求发起时间，unix 时间戳，如果和QQ服务器系统时间相差超过 10 分钟则会返回失败
        $data['title'] = $title;    //可选，模板名称
        $data['remark'] = $desc;    //可选，模板备注，比如申请原因，使用场景等
        $data['sig'] = hash("sha256", "appkey=".$this->appkey."&random=".$random."&time=".$curTime, FALSE);

        $result = $this->util->sendCurlPost($wholeUrl, $data);
        return json_decode($result, true);
    }

    /**
     * 修改模板
     * @param int       $id
     * @param int       $type       模板类型
     * @param string    $content    模板内容    {1}为您的登录验证码，请于{2}分钟内填写。如非本人操作，请忽略本短信。（其中{数字}为可自定义的内容，须从1开始连续编号，如{1}、{2}等。）
     * @param string    $desc 签名备注，比如申请原因，使用场景等，可选字段
     * @param string    $title
     * @return array
     *         {
     *         "result": 0, //0表示成功，非0表示失败
     *         "msg": "", //result非0时的具体错误信息
     *         "data": {
     *             "id": 123, //模板id
     *             "text": "xxxxx", //模板内容
     *             "status": 1, //0：已通过；1：待审核；2：已拒绝
     *             "type": 0 //0：普通短信模板；1：营销短信模板；2：语音模板
     *             }
     *         }
     */
    public function sms_template_update($id, $content, $type, $desc = null, $title = null)
    {
        $this->url = self::UPDATE_URL;
        $random = $this->util->getRandom();
        $curTime = time();
        $wholeUrl = $this->url . "?sdkappid=" . $this->appid . "&random=" . $random;

        // 按照协议组织 post 包体
        $data['tpl_id'] = $id;      //必填，模板服务端ID
        $data['text'] = $content;   //必填，模板内容
        $data['type'] = $type;          //必填，0:普通短信 1：营销短信
        $data['time'] = $curTime;   //必填，时间戳
        $data['title'] = $title;    //可选，模板名称
        $data['remark'] = $desc;    //可选，模板备注，比如申请原因，使用场景等
        $data['sig'] = hash("sha256", "appkey=".$this->appkey."&random=".$random."&time=".$curTime, FALSE);

        $result = $this->util->sendCurlPost($wholeUrl, $data);
        return json_decode($result, true);
    }

    /**
     * 删除签名
     * @param int $id 签名ID
     * @return array
     *                     {
     *                     "result": 0, //0表示成功，非0表示失败
     *                     "msg": "" //result非0时的具体错误信息
     *                     }
     */
    public function sms_template_del($id)
    {
        $this->url = self::UPDATE_URL;
        $random = $this->util->getRandom();
        $curTime = time();
        $wholeUrl = $this->url . "?sdkappid=" . $this->appid . "&random=" . $random;

        // 按照协议组织 post 包体
        $data['sig'] = hash("sha256", "appkey=".$this->appkey."&random=".$random."&time=".$curTime, FALSE);
        $data['time'] = $curTime;
        $data['tpl_id'] = $id;

        $result = $this->util->sendCurlPost($wholeUrl, $data);
        return json_decode($result, true);
    }

    /**
     * 检查签名状态
     * @param int $id 签名ID
     * @return array
     *                     {
     *                     "result": 0, //0表示成功，非0表示失败
     *                     "msg": "", //result非0时的具体错误信息
     *                     "count": 3, //result为0时有效，返回的信息条数，信息内容在data字段中
     *                     "data": [
     *                     {
     *                     "id": 123, //签名id
     *                     "text": "xxxxx", //签名内容
     *                     "status": 0, //0：已通过；1：待审核；2：已拒绝
     *                     "reply": "xxxxx" // 审批信息，如果status为2，会说明拒绝原因
     *                     },...
     *                     ]
     *                     }
     */
    public function sms_template_check($id)
    {
        $this->url = self::CHECK_URL;
        $random = $this->util->getRandom();
        $curTime = time();
        $wholeUrl = $this->url . "?sdkappid=" . $this->appid . "&random=" . $random;

        // 按照协议组织 post 包体
        $data['sig'] = hash("sha256", "appkey=".$this->appkey."&random=".$random."&time=".$curTime, FALSE);
        $data['time'] = $curTime;
        $data['tpl_id'] = $id;

        $result = $this->util->sendCurlPost($wholeUrl, $data);
        return json_decode($result, true);
    }
}