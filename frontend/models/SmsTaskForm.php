<?php
/**
 * 短信发送表单
 * User: collins
 * Date: 18-11-15
 */

namespace frontend\models;


use common\modules\finance\service\FinanceAccountService;
use common\modules\sms\data\SmsTaskData;
use common\modules\sms\data\SmsUploadData;
use common\modules\sms\models\SmsTask;
use common\modules\sms\models\SmsTemplate;
use common\modules\sms\service\SmsService;
use Yii;
use yii\base\Model;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class SmsTaskForm extends Model
{
    public $template_id;

    public $file;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['template_id', 'number'],
            ['template_id', 'required'],
            [
                'template_id',
                'in',
                'range' => SmsTemplate::find()->select('id')->where("verify_status = 0 and is_hidden = 0")->column(),
                'message' => yii::t('frontend', 'Select Sms Template'),
            ],

            ['file', 'file', 'extensions'=>'txt, csv, xls'],

        ];
    }

//    /**
//     * @inheritdoc
//     */
//    public function scenarios()
//    {
//        return [
//            'create' => ['template_id', 'file', 'verify_code'],
//            'sms' => ['username', 'captcha'],
//            'reset' => ['username', 'password', 'verify_code'],
//            'sms_reset' => ['username', 'captcha'],
//        ];
//    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'template_id' => yii::t('frontend', 'template_id'),
            'file' => yii::t('frontend', 'file'),
        ];
    }

    public function loadDefaultValues()
    {

    }

    /**
     * @return array|bool
     * @throws \yii\base\Exception
     */
    public function saveNotConfirm()
    {
        $upload = UploadedFile::getInstance($this, 'file');
        if ($upload !== null) {
            $uploadPath = yii::getAlias('@sms_dir/'.date("Y_m_d").'/');
            if (!FileHelper::createDirectory($uploadPath)) {
                $this->addError('sms_task', "Create directory failed " . $uploadPath);
                return false;
            }
            $fullName = $uploadPath . date('YmdHis') . '_' . uniqid() . '.' . $upload->getExtension();
            if (! $upload->saveAs($fullName)) {
                $this->addError('sms_task', yii::t('app', 'Upload {attribute} error: ' . $upload->error, ['attribute' => yii::t('app', 'Ad')]) . ': ' . $fullName);
                return false;
            }
            $this->file = str_replace($uploadPath, '', $fullName);
        }

        //保存入库,且返回
        $model = new SmsTaskData();
        $result = $model->add(Yii::$app->getUser()->getId(), $this->template_id, $this->file);
        if($result['error']){
            $this->addError('sms_task', $result['error']);
            return false;
        } else {
            return $result;
        }
    }

    public function save()
    {
        $file = isset($_FILES['list']) ? $_FILES['list'] : "";
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
        $success = $fail = $total = 0;
        $sms_model = new SmsService(Yii::$app->params['smsPlatform']);
        foreach ($sms_list as $item) {
            if (!$item) {
                continue;
            }
            $item_arr = explode(",", str_replace('"','', $item));
            if (count($item_arr)) {
                $mobile = array_shift($item_arr);
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
        return ['total'=>$total, 'success'=>$success, 'fail'=>$fail];
    }

}