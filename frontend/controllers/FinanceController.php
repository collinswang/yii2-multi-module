<?php

namespace frontend\controllers;

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
                        $uid = Yii::$app->getUser()->getId();
                        $acc_model = new FinanceAccountData();
                        $account = $acc_model->get_one($uid);
                        $searchModel = new FinanceFlowSearch();
                        $searchModel->uid = $uid;
                        $searchModel->invisible = 1;

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
        if(Yii::$app->getRequest()->getIsPost()){
//  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户UID',
//  `payable` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '交易金额',
//  `fee_rate` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '手续费率%',
//  `fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '税费金额',
//  `received` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '到帐金额',
//  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
//  `deal_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '支付时间',
//  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '支付方式(1-支付宝,2-微信支付,3-手动充值)',
//  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '支付状态(1-支付中, 2-成功,3-支付失败,4-退款)',
//  `admin_id` int(10) unsigned DEFAULT '0' COMMENT '管理员UID',
//  `admin_note` varchar(255) DEFAULT NULL COMMENT '管理员备注',
//  `invisible`
            $total = floatval(Yii::$app->getRequest()->post('total'));
            if($total<=0){
                Yii::$app->getSession()->setFlash('error', "请输入充值金额");
                return false;
            }

            $type = intval(Yii::$app->getRequest()->post('type'));
            if(!in_array($type, array_keys(FinanceIncomeData::$type_arr))){
                Yii::$app->getSession()->setFlash('error', "请选择支付方式");
                return false;
            }

            if($total && $type){
                $income = new FinanceIncome();
                $income->uid = Yii::$app->getUser()->getId();
                $income->payable = round($total*(1+Yii::$app->params['fee_rate']), 2);
                $income->fee_rate = Yii::$app->params['fee_rate'];
                $income->fee = round($total * $income->fee_rate, 2);
                $income->received = $total;
                $income->create_time = time();
                $income->type = $type;
                $income->status = FinanceIncomeData::STATUS_PAYING;
                $income->invisible = FinanceIncomeData::INVISIBLE_TRUE;
                if($income->validate() && $income->save()){
                    $income_id = $income->id;
                    switch ($income->type){
                        case FinanceIncomeData::TYPE_ALIPAY:
                            $result = alipayWeb::buildPay($income_id, $income->received, Yii::$app->getUser()->getIdentity()->username);
                            try {
                                file_put_contents("/home/web/web_log/pay_" . date("Y_m_d") . ".txt",
                                    var_dump($result) . "\r\n", FILE_APPEND);
                            } catch (\Exception $e) {
                            }
                            echo $result;
                            return $this->render('recharge');
                            break;
                        case FinanceIncomeData::TYPE_WECHAT:
                            Yii::$app->getSession()->setFlash('error', "暂时不支持此支付方式");
                            break;
                        default:
                            Yii::$app->getSession()->setFlash('error', "未知支付方式");
                            break;
                    }
                } else {
                    //print_r($income->getErrors());
                    Yii::$app->getSession()->setFlash('error', "操作失败");
                }
            }
        }

        return $this->render('recharge');
    }

}
