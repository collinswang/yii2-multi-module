<?php

namespace backend\controllers;

use Yii;
use common\modules\sms\models\SmsTaskSearch;
use common\modules\sms\models\SmsTask;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;
use backend\actions\SortAction;

/**
 * SmsTaskController implements the CRUD actions for SmsTask model.
 */
class SmsTaskController extends \yii\web\Controller
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'data' => function(){
                    
                        $searchModel = new SmsTaskSearch();
                        $dataProvider = $searchModel->search(yii::$app->getRequest()->getQueryParams());
                        return [
                            'dataProvider' => $dataProvider,
                            'searchModel' => $searchModel,
                        ];
                    
                }
            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => SmsTask::className(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => SmsTask::className(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => SmsTask::className(),
            ],
            'sort' => [
                'class' => SortAction::className(),
                'modelClass' => SmsTask::className(),
            ],
        ];
    }
}
