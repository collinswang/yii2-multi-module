<?php
/**
 * 短信发送类
 * User: cf8
 * Date: 18-3-22
 * Time: 上午11:12
 */

namespace console\controllers;


use common\modules\finance\data\FinanceAccountData;
use common\modules\finance\service\FinanceAccountService;
use common\modules\finance\service\FinanceIncomeService;
use \yii\console\Controller;

class FinanceIncomeController extends Controller
{
    public function actionAdd()
    {
        $uid = 2;
        $type = 1;
        $status = 1;
        $payable = rand(1,10);
        $model = new FinanceIncomeService();
        echo "$uid, $type, $status, $payable==";
        $result = $model->add($uid, $type, $status, $payable, $admin_id = 0, $admin_note ="", $create_time=null, $deal_time=0, $invisible = 1);
        print_r($result);
    }

    public function actionUpdate($id)
    {
        $status = 2;
        $admin_id = 1;
        $admin_note = "test";
        $deal_time = time();
        $invisible = 0;
        $model = new FinanceIncomeService();
        $result = $model->update($id, $status, $admin_id, $admin_note, $deal_time, $invisible);
        print_r($result);
    }

    public function actionList($uid)
    {
        $model = new FinanceAccountService();
        $detail = $model->get_one($uid);
        $model = new FinanceIncomeService();
        $result = $model->getList($uid, 1);
        $result['detail'] = $detail;
        print_r($result);
    }

}