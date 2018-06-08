<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-03-15 21:16
 */

namespace api\controllers;

use common\modules\sms\data\SmsTemplateData;
use common\modules\sms\models\Sms;
use common\modules\sms\service\SmsService;
use common\modules\sms\service\SmsTemplateService;
use Yii;
use yii\helpers\ArrayHelper;


/**
 * Sms controller
 */
class SmsController extends BaseController
{
    public function actionIndex()
    {
        return ['status'=>1, 'desc'=>"11111", 'uid'=>$this->uid];
    }

    /**
     * 发送记录
     * 上传文件说明：格式： “手机号”，“模板字段一”，“模板字段二”
     * @return array
     */
    public function actionSend()
    {
        //模板ID
        $tpl_id = intval($_POST['tpl_id']);
        $model_template = new SmsTemplateData();
        $tpl_detail = $model_template->get(SmsTemplateData::SEARCH_BY_ID, $tpl_id);
        if(!$tpl_detail){
            return ['status'=>-1, 'desc'=>"无效的模板"];
        }

        $sms_model = new SmsService(SmsService::SMS_SIGN_API_ALIDAYU);

        $file = $_FILES['list'];
        $sms_list = file_get_contents($file['tmp_name']);
        $sms_list = str_replace(["\r\n", "\r"], "\n", $sms_list);
        $sms_list = explode("\n", $sms_list);
        if($sms_list){
            foreach ($sms_list as $item) {
                if(!$item){continue;}
                $item_arr = explode(",", $item);
                if(count($item_arr)){
                    $mobile = array_shift($item_arr);
                    if($mobile){
                        $single_result = $sms_model->send_template_single($this->uid, $tpl_id, $mobile, $item_arr);
                        //$single_result['status'] >0 表示成功
                    }
                }
            }
        }
        return ['status'=>1, 'desc'=>"11111", 'uid'=>$this->uid];
    }

    public function actionPush()
    {
        $model = new SmsService(SmsService::SMS_SIGN_API_ALIDAYU);
        $result = $model->send_sms_syn();
        print_r($result);
    }

}
