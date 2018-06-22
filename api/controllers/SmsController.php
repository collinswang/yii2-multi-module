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

    /**
     * 以上传文件的方式批量发送短信
     * @var int     tpl_id      短信模板ID
     * @var string  file        上传文件，格式： “手机号”，“模板字段一”，“模板字段二”
     * @return array
     * @example curl -F "tpl_id=13" -F "list=@file.csv" -H "token:98f5c8c4bdce974a90d177261f1db082" "http://api.k5.com/?r=sms/send&uid=1"
     */
    public function actionSend()
    {
        //模板ID
        $tpl_id = intval($_POST['tpl_id']);
        if (!$tpl_id) {
            return ['status'=>-1, 'desc'=>"无效的模板"];
        }

        $model_template = new SmsTemplateData();
        $tpl_detail = $model_template->get(SmsTemplateData::SEARCH_BY_ID, $tpl_id);
        if (!$tpl_detail) {
            return ['status'=>-1, 'desc'=>"无效的模板"];
        }

        $sms_model = new SmsService(Yii::$app->params['smsPlatform']);

        $file = $_FILES['list'];
        if(!$file){
            return ['status'=>-2, 'desc'=>"没有上传文件"];
        }
        $sms_list = @file_get_contents($file['tmp_name']);
        if(!$sms_list){
            return ['status'=>-3, 'desc'=>"上传的文件为空"];
        }

        $sms_list = str_replace(["\r\n", "\r"], "\n", $sms_list);
        $sms_list = explode("\n", $sms_list);
        $total = $success = $fail = 0;
        if ($sms_list) {
            foreach ($sms_list as $item) {
                if (!$item) {
                    continue;
                }
                $item_arr = explode(",", str_replace('"','', $item));
                if (count($item_arr)) {
                    $mobile = array_shift($item_arr);
                    if ($mobile) {
                        $single_result = $sms_model->sendTemplateSingle($this->uid, $tpl_detail, $mobile, $item_arr);
                        //$single_result['status'] >0 表示成功
                        if($single_result['status']>0){
                            $success++;
                        } else {
                            $fail++;
                        }
                    }
                }
                $total++;
            }
        } else {
            return ['status'=>-3, 'desc'=>"上传的文件为空或格式不对"];
        }

        return ['status'=>1, 'desc'=>"任务添加成功", 'total'=>$total, 'success'=>$success, 'fail'=>$fail, 'uid'=>$this->uid];
    }

    /**
     * 检查短信发送记录
     */
    public function actionCheck($page)
    {
        $uid = intval($this->uid);
        $page = intval($page);

        $model = new SmsService(Yii::$app->params['smsPlatform']);
        $result = $model->getSendList($uid, $page);
        return $result;
    }

}
