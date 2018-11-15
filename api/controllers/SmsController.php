<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-03-15 21:16
 */

namespace api\controllers;

use common\components\Tools;
use common\modules\finance\service\FinanceAccountService;
use common\modules\sms\data\SmsTemplateData;
use common\modules\sms\data\SmsUploadData;
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
     * @example curl -F "tpl_id=13" -F "upfile=@file.csv" "http://api.k3.com/?r=sms/send&uid=8&mobile=13651081267&token=8fb3662c974479460f8bb4f960baa500&bid=%31%5a%53%4b%4d%33%33%57%34%42%36&dev=%34%37%37%65%33%38%63%64%30%35%33%65%34%33%61%37%35%37%61%39%64%66%34%33%34%30%63%30%34%36%34%64&did=%57%44%43%20%57%44%31%30%53%50%5a%58%2d%30%30%5a%31%30%54%30%20%41%54%41%20%44%65%76%69%63%65&mac=%36%43%3a%38%38%3a%31%34%3a%32%37%3a%38%44%3a%41%43"
     */
    public function actionSend()
    {
        //模板ID
        file_put_contents("request.txt", json_encode([$_GET, $_POST, $_FILES])."\r\n", FILE_APPEND);
//        $tpl_id = intval($_POST['tpl_id']);
        $tpl_id = 18;
        if (!$tpl_id) {
            return ['status'=>-1, 'desc'=>"无效的模板"];
        }

        $model_template = new SmsTemplateData();
        $tpl_detail = $model_template->get(SmsTemplateData::SEARCH_BY_ID, $tpl_id);
        if (!$tpl_detail) {
            return ['status'=>-1, 'desc'=>"无效的模板2"];
        }

        $file = isset($_FILES['upfile']) ? $_FILES['upfile'] : "";
        if(!$file){
            return ['status'=>-2, 'desc'=>"没有上传文件"];
        }
        $sms_list = @file_get_contents($file['tmp_name']);
        if(!$sms_list){
            return ['status'=>-3, 'desc'=>"上传的文件为空"];
        }

        $sms_list = str_replace(["\r\n", "\r"], "\n", $sms_list);
        $success = $fail = 0;
        $sms_list = explode("\n", $sms_list);
        $total = count($sms_list);
        if ($sms_list) {
            //TODO 检查余额是否足够
            $total_price = Yii::$app->params['price_per_sms'] * $total;
            $service_account = new FinanceAccountService();
            $is_allow = $service_account->check_total_usable($this->uid, $total_price);
            //余额不足
            if(!$is_allow){
                return ['status'=>-5, 'desc'=>"余额不足，请及时充值"];
            }

            //保存入sms_upload
            $upload_id = $this->save_upload($this->uid, $tpl_detail['source'], $tpl_detail['template_id'], $total);
            if($upload_id){
                //保存入sms
                $save_result = $this->save_sms($this->uid, $tpl_detail, $sms_list, $upload_id);
                //更新sms_upload数量
                if($upload_id && $save_result['total']){
                    $model = new SmsUploadData();
                    $model->update($upload_id, ['total'=>$save_result['total']]);
                }
            } else {
                return ['status'=>-3, 'desc'=>"上传失败"];
            }
        } else {
            return ['status'=>-3, 'desc'=>"上传的文件为空或格式不对"];
        }

        return ['status'=>1, 'desc'=>"任务添加成功", 'total'=>$save_result['total'], 'success'=>$save_result['success'], 'fail'=>$save_result['fail'], 'uid'=>$this->uid];
    }

    /**
     * 添加入sms_upload表
     * @param $uid
     * @param $source
     * @param $template_id
     * @param $total
     * @return int
     */
    private function save_upload($uid, $source, $template_id, $total)
    {
        $model = new SmsUploadData();
        $data = [
            'uid' => $uid,
            'source' => $source,
            'template_id' => $template_id,
            'total' => $total,
            'is_hidden' => 0,
        ];
        $upload_id = $model->add($data);
        return $upload_id;
    }

    /**
     * 添加入sms表
     * @param $uid
     * @param $tpl_detail
     * @param $sms_list
     * @param $upload_id
     * @return array
     */
    private function save_sms($uid, $tpl_detail, $sms_list, $upload_id)
    {
        $success = $fail = $total = $err = 0;
        $sms_model = new SmsService(Yii::$app->params['smsPlatform']);
        foreach ($sms_list as $item) {
            if (!$item) {
                continue;
            }
            $item_arr = explode(",", str_replace('"','', $item));
            if (count($item_arr)) {
                $mobile = array_shift($item_arr);
                if(!Tools::check_mobile($mobile)){
                    $err++;
                    continue;
                }
                if ($mobile) {
                    $single_result = $sms_model->sendTemplateSingle($uid, $tpl_detail, $mobile, $item_arr, $upload_id);
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
        return ['total'=>$total, 'success'=>$success, 'fail'=>$fail, 'err'=>$err];
    }

    /**
     * 检查短信上传记录
     * @param $page
     * @return array
     */
    public function actionCheckUpload($page = 1)
    {
        $uid = intval($this->uid);
        $page = intval($page);

        $model = new SmsService(Yii::$app->params['smsPlatform']);
        $result = $model->getUploadList($uid, $page);
        $result['status'] = 1;
        $result['desc'] = "成功";
        $result['title'] = [
            "id" => "ID",
            "source" => "渠道",
            "template_id" => "模板",
            "total" => "发送数量",
            "total_success" => "成功数量",
            "start_time" => "发送时间",
            "operate" => "操作"
        ];
        return $result;
    }

    /**
     * 检查短信发送记录
     * @param $page
     * @param $upload_id
     * @return array
     */
    public function actionCheckUploadDetail($page = 1, $upload_id = 0)
    {
        $uid = intval($this->uid);
        $page = intval($page);
        $upload_id = intval($upload_id);

        $model = new SmsService(Yii::$app->params['smsPlatform']);
        $result = $model->getSendList($uid, $page, $upload_id);
        $result['status'] = 1;
        $result['desc'] = "成功";
        $result['title'] = [
            "source" => "渠道",
            "template_id" => "模板",
            "mobile" => "手机",
            "send_status" => "发送状态",
            "send_time" => "发送时间",
            "content" => "发送内容",
        ];
        return $result;
    }

}
