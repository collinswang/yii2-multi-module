<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-03-15 21:16
 */

namespace frontend\controllers;

use backend\actions\CreateAction;
use backend\actions\DeleteAction;
use backend\actions\IndexAction;
use backend\actions\SortAction;
use backend\actions\UpdateAction;
use common\modules\sms\data\SmsTemplateData;
use common\modules\sms\data\SmsUploadData;
use common\modules\sms\models\SmsTemplate;
use common\modules\sms\service\SmsService;
use frontend\models\SmsForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;


/**
 * Sms controller
 */
class SmsController extends BaseController
{

    public function actions()
    {
        return [
//            'index' => [
//                'class' => IndexAction::className(),
//                'data' => function(){
//                    $dataProvider = new ActiveDataProvider([
//                        'query' => SmsForm::find()->where(['type'=>SmsForm::TYPE_AD])->orderBy('sort,id'),
//                    ]);
//                    return [
//                        'dataProvider' => $dataProvider,
//                    ];
//                }
//            ],
//            'send' => [
//                'class' => CreateAction::className(),
//                'modelClass' => SmsForm::className(),
//            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => SmsForm::className(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => SmsForm::className(),
            ],
            'sort' => [
                'class' => SortAction::className(),
                'modelClass' => SmsForm::className(),
            ],
        ];
    }


    /**
     * 以上传文件的方式批量发送短信
     * @var int     tpl_id      短信模板ID
     * @var string  file        上传文件，格式： “手机号”，“模板字段一”，“模板字段二”
     * @return string|\yii\console\Response|\yii\web\Response
     */
    public function actionSend()
    {

        if (Yii::$app->getUser()->getIsGuest()) {
            return Yii::$app->getResponse()->redirect(['/site/login']);
        }

        $model = new SmsForm();
        if (Yii::$app->getRequest()->getIsPost()) {
            $model->load(Yii::$app->getRequest()->post());
            $model->file = UploadedFile::getInstances($model, 'file');
            if ($id = $model->saveNotConfirm()) {

                // 文件上传成功
                return $this->render('send-confirm', [
                    'model' => $model,
                ]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);

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
