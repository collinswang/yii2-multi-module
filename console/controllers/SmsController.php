<?php
/**
 * 短信发送类
 * User: cf8
 * Date: 18-3-22
 * Time: 上午11:12
 */

namespace console\controllers;


use common\modules\sms\base\AliSmsClient;
use common\modules\sms\base\SmsInterface;
use common\modules\sms\data\SmsData;
use \common\modules\sms\models\SmsSign;
use common\modules\sms\service\SmsService;
use common\modules\sms\service\SmsSignService;
use Yii;

class SmsController extends \yii\console\Controller
{

    /**
     * 异步推送
     * php yii sms/queue
     */
    public function actionQueue()
    {
        $smsService = new SmsService(Yii::$app->params['smsPlatform']);
        $status = true;
        while($status){
            $queueData = $smsService->sendSmsSync();
            if($queueData == -1){
                sleep(1);
                echo "Zzzz..\r\n";
            } else {
                echo "处理中..\r\n";
            }
        }
    }

    /**
     * 检查签名审核结果
     */
    public function actionCheck()
    {
        $page_size = 100;
        $sql = "verify_status = 1 and is_hidden=0";
        $sms_sign_api = SmsSignService::getSmsSignApi();
        foreach (SmsSign::find()->where($sql)->asArray()->batch($page_size) as $list) {
            if($list){
                foreach ($list as $item) {
                    $model = new SmsSignService(new $sms_sign_api[$item['source']]);
                    $model->check($item);
                }
            }
        }
    }

    public function actionTest()
    {
        $attr = SmsService::$sms_sign_api[SmsService::SMS_SIGN_API_ALIDAYU];
        $model = new $attr();
        if(!$model instanceof SmsInterface){
            return ['status'=>-1, 'desc'=>'传入非SmsInterface的实例'];
        } else {
            echo 22222;
        }
        $mobile = "13651081267";
        $tpl_id = "SMS_116780127";
        $params = ['code'=>rand(100000,999999)];
        $result = $model->smsSendTemplateMsgSingle($mobile, $tpl_id , $params);
        print_r($result);
    }

    public function actionGet()
    {
        $sms_api = SmsService::getSmsApi();
        $model = new SmsService(new $sms_api[1]);
        $result = $model->pullStatus(0, 1);
        print_r($result);
    }



}