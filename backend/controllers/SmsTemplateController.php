<?php

namespace backend\controllers;

use Yii;
use common\modules\sms\models\SmsTemplate;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;
use backend\actions\SortAction;
use yii\data\ActiveDataProvider;

/**
 * SmsTemplateController implements the CRUD actions for SmsTemplate model.
 */
class SmsTemplateController extends \yii\web\Controller
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'data' => function(){
                        $dataProvider = new ActiveDataProvider([
                            'query' => SmsTemplate::find(),
                            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
                        ]);

                        return [
                            'dataProvider' => $dataProvider,
                        ];
                    
                }
            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => SmsTemplate::className(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => SmsTemplate::className(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => SmsTemplate::className(),
            ],
            'sort' => [
                'class' => SortAction::className(),
                'modelClass' => SmsTemplate::className(),
            ],
        ];
    }
}
