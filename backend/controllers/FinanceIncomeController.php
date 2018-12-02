<?php

namespace backend\controllers;

use common\modules\finance\data\FinanceIncomeData;
use Yii;
use common\modules\finance\models\FinanceIncomeSearch;
use common\modules\finance\models\FinanceIncome;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;
use backend\actions\SortAction;

/**
 * FinanceIncomeController implements the CRUD actions for FinanceIncome model.
 */
class FinanceIncomeController extends \yii\web\Controller
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'data' => function(){
                    
                        $searchModel = new FinanceIncomeSearch();
                        $searchModel->status = FinanceIncomeData::STATUS_SUCCESS;
                        $dataProvider = $searchModel->search(yii::$app->getRequest()->getQueryParams());
                        return [
                            'dataProvider' => $dataProvider,
                            'searchModel' => $searchModel,
                        ];
                    
                }
            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => FinanceIncome::className(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => FinanceIncome::className(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => FinanceIncome::className(),
            ],
            'sort' => [
                'class' => SortAction::className(),
                'modelClass' => FinanceIncome::className(),
            ],
        ];
    }
}
