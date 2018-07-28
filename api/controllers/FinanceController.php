<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-03-15 21:16
 */

namespace api\controllers;

use common\modules\finance\data\FinanceAccountData;
use common\modules\finance\data\FinanceFlowData;
use common\modules\finance\models\FinanceFlow;
use common\modules\finance\service\FinanceAccountService;
use common\modules\finance\service\FinanceFlowService;
use common\modules\finance\service\FinanceIncomeService;
use common\modules\sms\data\SmsTemplateData;
use common\modules\sms\data\SmsUploadData;
use common\modules\sms\models\Sms;
use common\modules\sms\service\SmsService;
use common\modules\sms\service\SmsTemplateService;
use Yii;
use yii\helpers\ArrayHelper;


/**
 * Finance controller
 */
class FinanceController extends BaseController
{
    /**
     * 返回余额及最近的一页充值记录
     * @return array
     */
    public function actionIndex()
    {
        if($this->uid <=0){
            return [];
        }
        $model = new FinanceAccountService();
        $detail = $model->get_one($this->uid);
        $model = new FinanceFlowService();
        $result = $model->get_list($this->uid, 1);
        $result['detail'] = $detail;
        $result['status'] = 1;
        $result['desc'] = "成功";
        return $result;
    }

    /**
     * 充值列表
     * @param int $page
     * @param int $page_size
     * @return array
     */
    public function actionIncomeList($page = 2, $page_size = 20)
    {
        if($this->uid <=0){
            return [];
        }
        $model = new FinanceIncomeService();
        $result = $model->getList($this->uid, $page, $page_size);
        return $result;
    }

    /**
     * 返回消费列表
     * @param int $page
     * @param int $page_size
     * @return array
     */
    public function actionOutcomeList($page = 1, $page_size = 20)
    {
        if($this->uid <=0){
            return [];
        }
        $model = new FinanceIncomeService();
        $result = $model->getList($this->uid, $page, $page_size);
        return $result;
    }

}
