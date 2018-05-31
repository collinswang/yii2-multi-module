<?php

namespace backend\controllers;

use Yii;
use common\modules\sms\models\Sms;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;
use backend\actions\SortAction;
use yii\data\ActiveDataProvider;

/**
 * SmsController implements the CRUD actions for Sms model.
 */
class SmsController extends \yii\web\Controller
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'data' => function(){
                    
                        $dataProvider = new ActiveDataProvider([
                            'query' => Sms::find(),
                            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
                            'pagination' => [
                                'pageSize' => 10,
                            ],
                        ]);

                        return [
                            'dataProvider' => $dataProvider,
                        ];
                    
                }
            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => Sms::className(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => Sms::className(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => Sms::className(),
            ],
            'sort' => [
                'class' => SortAction::className(),
                'modelClass' => Sms::className(),
            ],
        ];
    }
}
