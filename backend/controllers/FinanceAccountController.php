<?php

namespace backend\controllers;

use Yii;
use common\modules\finance\models\FinanceAccountSearch;
use common\modules\finance\models\FinanceAccount;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;
use backend\actions\SortAction;

/**
 * FinanceAccountController implements the CRUD actions for FinanceAccount model.
 */
class FinanceAccountController extends \yii\web\Controller
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'data' => function(){
                    
                        $searchModel = new FinanceAccountSearch();
                        $dataProvider = $searchModel->search(yii::$app->getRequest()->getQueryParams());
                        return [
                            'dataProvider' => $dataProvider,
                            'searchModel' => $searchModel,
                        ];
                    
                }
            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => FinanceAccount::className(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => FinanceAccount::className(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => FinanceAccount::className(),
            ],
            'sort' => [
                'class' => SortAction::className(),
                'modelClass' => FinanceAccount::className(),
            ],
        ];
    }
}
