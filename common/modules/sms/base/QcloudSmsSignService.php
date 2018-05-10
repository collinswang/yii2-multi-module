<?php
/**
 * Qcloud签名管理模块
 */
namespace common\modules\sms\base;

use Qcloud\Sms\SmsSenderUtil;
use Yii;

class QcloudSmsSignService implements  SmsSignInterface
{
    const ADD_URL = 'https://yun.tim.qq.com/v5/tlssmssvr/add_sign';
    const UPDATE_URL = 'https://yun.tim.qq.com/v5/tlssmssvr/mod_sign';
    const CHECK_URL = 'https://yun.tim.qq.com/v5/tlssmssvr/get_sign';

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
     * 创建签名
     * @param string $sign 签名内容，不带【】，例如：【腾讯科技】这个签名，这里填"腾讯科技"
     * @param string $desc 签名备注，比如申请原因，使用场景等，可选字段
     * @return array
     *                     {
     *                     "result": 0, //0表示成功，非0表示失败
     *                     "msg": "", //result非0时的具体错误信息
     *                     "data": {
     *                     "id": 123, //签名id
     *                     "text": "xxxxx", //签名内容
     *                     "status": 1, //0：已通过；1：待审核；2：已拒绝
     *                     }
     *                     }
     */
    public function sms_sign_add($sign, $desc)
    {
        $this->url = self::ADD_URL;
        $random = $this->util->getRandom();
        $curTime = time();
        $wholeUrl = $this->url . "?sdkappid=" . $this->appid . "&random=" . $random;

        // 按照协议组织 post 包体
        $data['remark'] = $desc;
        $data['text'] = $sign;
        $data['sig'] = hash("sha256", "appkey=".$this->appkey."&random=".$random."&time=".$curTime, FALSE);
        $data['time'] = $curTime;

        $result = $this->util->sendCurlPost($wholeUrl, $data);
        return json_decode($result, true);
    }

    /**
     * 修改签名
     * @param int    $sign_id   签名ID
     * @param string $sign 签名内容，不带【】，例如：【腾讯科技】这个签名，这里填"腾讯科技"
     * @param string $desc 签名备注，比如申请原因，使用场景等，可选字段
     * @return array
     *                     {
     *                     "result": 0, //0表示成功，非0表示失败
     *                     "msg": "", //result非0时的具体错误信息
     *                     "data": {
     *                     "id": 123, //签名id
     *                     "text": "xxxxx", //签名内容
     *                     "status": 1, //0：已通过；1：待审核；2：已拒绝
     *                     }
     *                     }
     */
    public function sms_sign_update($sign_id, $sign, $desc)
    {
        $this->url = self::UPDATE_URL;
        $random = $this->util->getRandom();
        $curTime = time();
        $wholeUrl = $this->url . "?sdkappid=" . $this->appid . "&random=" . $random;

        // 按照协议组织 post 包体
        $data['remark'] = $desc;
        $data['text'] = $sign;
        $data['sig'] = hash("sha256", "appkey=".$this->appkey."&random=".$random."&time=".$curTime, FALSE);
        $data['time'] = $curTime;
        $data['sign_id'] = $sign_id;

        $result = $this->util->sendCurlPost($wholeUrl, $data);
        return json_decode($result, true);
    }

    /**
     * 删除签名
     * @param array $sign_id 签名ID
     * @return array
     *                     {
     *                     "result": 0, //0表示成功，非0表示失败
     *                     "msg": "" //result非0时的具体错误信息
     *                     }
     */
    public function sms_sign_del($sign_id)
    {
        $this->url = self::UPDATE_URL;
        $random = $this->util->getRandom();
        $curTime = time();
        $wholeUrl = $this->url . "?sdkappid=" . $this->appid . "&random=" . $random;

        // 按照协议组织 post 包体
        $data['sig'] = hash("sha256", "appkey=".$this->appkey."&random=".$random."&time=".$curTime, FALSE);
        $data['time'] = $curTime;
        $data['sign_id'] = $sign_id;

        $result = $this->util->sendCurlPost($wholeUrl, $data);
        return json_decode($result, true);
    }

    /**
     * 检查签名状态
     * @param array $sign_id 签名ID
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
    public function sms_sign_check($sign_id)
    {
        $this->url = self::CHECK_URL;
        $random = $this->util->getRandom();
        $curTime = time();
        $wholeUrl = $this->url . "?sdkappid=" . $this->appid . "&random=" . $random;

        // 按照协议组织 post 包体
        $data['sig'] = hash("sha256", "appkey=".$this->appkey."&random=".$random."&time=".$curTime, FALSE);
        $data['time'] = $curTime;
        $data['sign_id'] = $sign_id;

        $result = $this->util->sendCurlPost($wholeUrl, $data);
        return json_decode($result, true);
    }
}