<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-03-15 21:16
 */

namespace api\controllers;

use common\modules\sms\data\SmsTemplateData;
use common\modules\sms\service\SmsService;
use common\modules\sms\service\SmsTemplateService;


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

        $model_sign = SmsService::get_sms_api()[1];
        $sms_model = new SmsService($model_sign);

        $file = $_FILES['list'];
        $sms_list = file_get_contents($file['tmp_name']);
        $sms_list = str_replace(["\r\n", "\r"], "\n", $sms_list);
        $sms_list = explode("\n", $sms_list);
        if($sms_list){
            $mobile_list = [];
            foreach ($sms_list as $item) {
                if(!$item){continue;}
                $item_arr = explode(",", $item);
                if(count($item_arr)){
                    unset($item_arr[0]);
                    $build_result = SmsService::build_content($this->uid, $tpl_id, $item_arr);
                    if($build_result['status'] == 1){
                        $content = $build_result['content'];
                    } else {
                        return ['status'=>-1, 'desc'=>"模板与所传参数对应不上，请检查"];
                    }
                }
                //入库并执行短信发送队列
                $mobile_list[] = $item_arr[0];
                unset($item_arr[0]);
                $params[] = $item_arr;
            }

            $sms_model->send_template_batch($this->uid, $tpl_id, $mobile_list, $params);
        }
        exit;
        return ['status'=>1, 'desc'=>"11111", 'uid'=>$this->uid];
    }

}
