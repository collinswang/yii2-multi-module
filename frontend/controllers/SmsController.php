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
            'task_id'   => $task_id,
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

}
