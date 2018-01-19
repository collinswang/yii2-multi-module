<?php
/**
 * Qcloud签名管理模块
 */
namespace common\modules\sms\service;

use common\modules\sms\base\SmsSignInterface;
use Qcloud\Sms\SmsSenderUtil;
use Yii;

class QcloudSmsSignService implements  SmsSignInterface
{
    private $url;
    private $appid;
    private $appkey;
    private $util;

    public function __construct()
    {
        $this->url = 'https://yun.tim.qq.com/v5/tlssmssvr/add_sign';
        $this->appid = Yii::$app->params['qcloud_sms']['appid'];
        $this->appkey = Yii::$app->params['qcloud_sms']['appkey'];
        $this->util = new SmsSenderUtil();
    }

    public function add()
    {
        $random = $this->util->getRandom();
        $curTime = time();
        $wholeUrl = $this->url . "?sdkappid=" . $this->appid . "&random=" . $random;

        // 按照协议组织 post 包体
        $data['remark'] = '';
        $data['text'] = '';
        $data['sig'] = hash("sha256",
            "appkey=".$this->appkey."&random=".$random."&time="
            .$curTime, FALSE);
        $data['time'] = $curTime;
        return json_encode([$wholeUrl, $data]);
        exit;
        return $this->util->sendCurlPost($wholeUrl, $data);
    }

    public function update()
    {

    }

    public function del()
    {

    }

    public function check()
    {

    }
}