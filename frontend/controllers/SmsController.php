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
use backend\models\Sms;
use common\modules\finance\service\FinanceAccountService;
use common\modules\sms\data\SmsTaskData;
use common\modules\sms\data\SmsTemplateData;
use common\modules\sms\data\SmsUploadData;
use common\modules\sms\models\SmsSearch;
use common\modules\sms\models\SmsTask;
use common\modules\sms\models\SmsTaskSearch;
use common\modules\sms\models\SmsTemplate;
use common\modules\sms\service\SmsService;
use frontend\models\SmsTaskForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\web\UploadedFile;


/**
 * Sms controller
 */
class SmsController extends BaseController
{

    const PAGE_SIZE = 20;
//    public function actions()
//    {
//        return [
////            'update' => [
////                'class' => UpdateAction::className(),
////                'modelClass' => SmsTaskForm::className(),
////            ],
////            'delete' => [
////                'class' => DeleteAction::className(),
////                'modelClass' => SmsTaskForm::className(),
////            ],
////            'sort' => [
////                'class' => SortAction::className(),
////                'modelClass' => SmsTaskForm::className(),
////            ],
//        ];
//    }

    public function init()
    {
        if (Yii::$app->getUser()->getIsGuest()) {
            return Yii::$app->getResponse()->redirect(['/site/login']);
        }
    }


    /**
     * 以上传文件的方式批量发送短信
     * @var int     tpl_id      短信模板ID
     * @var string  file        上传文件，格式： “手机号”，“模板字段一”，“模板字段二”
     * @return string|\yii\console\Response|\yii\web\Response
     * @throws \yii\base\Exception
     */
    public function actionSend()
    {

        $model = new SmsTaskForm();
        if (Yii::$app->getRequest()->getIsPost()) {
            $model->load(Yii::$app->getRequest()->post());
            $model->file = UploadedFile::getInstances($model, 'file');
            $result = $model->saveNotConfirm();
            if ($result['status']>=0) {
                // 文件上传成功
                return $this->redirect(['confirm', 'task_id'=>$result['id']]);
            } else {
                $errors = $model->getErrors();
                $err = '';
                foreach ($errors as $v) {
                    $err .= $v[0] . '<br>';
                }
                Yii::$app->getSession()->setFlash('error', $err);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);

    }

    /**
     * 确认执行任务: 付款,完成后入库
     * @return string|\yii\web\Response
     * @throws \yii\db\Exception
     */
    public function actionConfirm()
    {
        $model = new SmsTaskData();
        $task_id = Yii::$app->request->get('task_id');
        $task = SmsTask::findOne($task_id);
        if(!$task || $task->status !=0){
            Yii::$app->getSession()->setFlash('error', '任务不存在3!');
        }
        $fin_model = new FinanceAccountService();
        $finance = $fin_model->get_one($task->uid);
        //分析上传文件,获取总条数和EXAMPLE
        $check_result = $model->check_task_list($task->template_id, $task->file);
        if($check_result['status'] <=0){
            Yii::$app->getSession()->setFlash('error', '模板不存在');
        }

        if (Yii::$app->getRequest()->getIsPost()) {

            $task_id = Yii::$app->request->post('task_id', 0);
            if(!$task_id){
                Yii::$app->getSession()->setFlash('error', '任务不存在1!');
            }

            $task = SmsTask::findOne($task_id);
            if(!$task || $task->status !=0){
                Yii::$app->getSession()->setFlash('error', '任务不存在2!');
            }

            $result = $model->confirmTask($task_id);

            if ($result['status']>=0) {
                // 文件上传成功
                return $this->redirect(['task-list']);
            } else {
                Yii::$app->getSession()->setFlash('error', $result['msg']);
            }
        }
        return $this->render('confirm', [
            'list' => $check_result['list'],
            'info' => $task->attributes,
            'id'   => $task_id,
            'finance' => $finance
        ]);
    }

    public function actionIndex()
    {
        $searchModel = new SmsSearch();
        $searchModel->uid = Yii::$app->getUser()->getId();
        $dataProvider = $searchModel->search(yii::$app->getRequest()->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionTaskList()
    {
        $searchModel = new SmsTaskSearch();
        $searchModel->uid = Yii::$app->getUser()->getId();
        $dataProvider = $searchModel->search(yii::$app->getRequest()->getQueryParams());

        return $this->render('task_index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
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
