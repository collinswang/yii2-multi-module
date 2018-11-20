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
use common\modules\finance\models\FinanceFlow;
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
class FinanceController extends BaseController
{

    const PAGE_SIZE = 20;


    public function init()
    {
        if (Yii::$app->getUser()->getIsGuest()) {
            return Yii::$app->getResponse()->redirect(['/site/login']);
        }
    }


    public function actionIndex()
    {
        $searchModel = new FinanceFlow();
        $searchModel->uid = Yii::$app->getUser()->getId();
        $dataProvider = $searchModel->search(yii::$app->getRequest()->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }
}
