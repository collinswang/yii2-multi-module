<?php
/**
 * 短信发送类
 * User: cf8
 * Date: 18-3-22
 * Time: 上午11:12
 */

namespace console\controllers;


use \common\modules\sms\models\SmsSign;
use common\modules\sms\service\SmsService;
use common\modules\sms\service\SmsSignService;

class SmsController extends \yii\console\Controller
{
    /**
     * 检查签名审核结果
     */
    public function actionCheck()
    {
        $page_size = 100;
        $sql = "verify_status = 1 and is_hidden=0";
        $sms_sign_api = SmsSignService::get_sms_sign_api();
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
        $sms_api = SmsService::get_sms_api();
        $model = new SmsService(new $sms_api[1]);
        $uid=  123;
        $type = 0;
        $tpl_id = 1;
        $mobile = ["13651081267", "13712114574"];
        $params = ["测试公司A","服务器B","100元"];
        $result = $model->send_template_batch($uid, $type, $tpl_id, $mobile, $params);
        print_r($result);
    }

    public function actionGet()
    {
        $sms_api = SmsService::get_sms_api();
        $model = new SmsService(new $sms_api[1]);
        $result = $model->pull_status(0, 1);
        print_r($result);
    }

}