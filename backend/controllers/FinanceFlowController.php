<?php

namespace backend\controllers;

use Yii;
use common\modules\finance\models\FinanceFlowSearch;
use common\modules\finance\models\FinanceFlow;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;
use backend\actions\SortAction;

/**
 * FinanceFlowController implements the CRUD actions for FinanceFlow model.
 */
class FinanceFlowController extends \yii\web\Controller
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'data' => function(){
                    
                        $searchModel = new FinanceFlowSearch();
                        $dataProvider = $searchModel->search(yii::$app->getRequest()->getQueryParams());
                        return [
                            'dataProvider' => $dataProvider,
                            'searchModel' => $searchModel,
                        ];
                    
                }
            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => FinanceFlow::className(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => FinanceFlow::className(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => FinanceFlow::className(),
            ],
            'sort' => [
                'class' => SortAction::className(),
                'modelClass' => FinanceFlow::className(),
            ],
        ];
    }
}
