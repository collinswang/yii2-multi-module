<?php

namespace backend\controllers;

use common\components\alipay\alipayWeb;
use common\modules\finance\data\FinanceAccountData;
use common\modules\finance\data\FinanceIncomeData;
use common\modules\finance\models\FinanceIncome;
use Yii;
use common\modules\finance\models\FinanceFlowSearch;
use backend\actions\IndexAction;

/**
 * FinanceController implements the CRUD actions for FinanceFlow model.
 */
class FinanceController extends \yii\web\Controller
{

    public function init()
    {
        if (Yii::$app->getUser()->getIsGuest()) {
            return Yii::$app->getResponse()->redirect(['/site/login']);
        }
        parent::init();
    }

    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'data' => function(){
                        $uid = Yii::$app->request->get('uid');
                        $acc_model = new FinanceAccountData();
                        $account = $acc_model->get_one($uid);
                        $searchModel = new FinanceFlowSearch();
                        $searchModel->uid = $uid;

                        $dataProvider = $searchModel->search(yii::$app->getRequest()->getQueryParams());
                        return [
                            'uid'   => $uid,
                            'account'   => $account,
                            'dataProvider' => $dataProvider,
                            'searchModel' => $searchModel,
                        ];
                    
                }
            ],
        ];
    }

    public function actionRecharge()
    {
        return $this->render('recharge');
    }

}
