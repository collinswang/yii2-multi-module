<?php
/**
 * 签名异步更新脚本
 * User: cf8
 * Date: 18-3-22
 * Time: 上午11:12
 */

namespace console\controllers;


use common\modules\sms\base\QcloudSmsTemplateService;
use \common\modules\sms\models\SmsSign;
use common\modules\sms\service\SmsSignService;

class SmsTemplateController extends \yii\console\Controller
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

    public function actionTestAdd()
    {
        $content = "您的{1}已经通过{2}发货,快递单号:{3},请注意查收";
        $title = "发货提醒";
        $desc = "快递发货提醒";
        $type = 0;
        $sms_template = new QcloudSmsTemplateService();
        $result = $sms_template->sms_template_add($content, $type, $desc, $title);
        print_r($result);
    }
}