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

    /**
     * 创建签名
     * @param string    $sign   签名内容，不带【】，例如：【腾讯科技】这个签名，这里填"腾讯科技"
     * @param string    $desc   签名备注，比如申请原因，使用场景等，可选字段
     * @return string
     */
    public function add($sign, $desc)
    {
        $random = $this->util->getRandom();
        $curTime = time();
        $wholeUrl = $this->url . "?sdkappid=" . $this->appid . "&random=" . $random;

        // 按照协议组织 post 包体
        $data['remark'] = $desc;
        $data['text'] = $sign;
        $data['sig'] = hash("sha256",
            "appkey=".$this->appkey."&random=".$random."&time="
            .$curTime, FALSE);
        $data['time'] = $curTime;

        $result = $this->util->sendCurlPost($wholeUrl, $data);
        return json_encode($result, true);
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