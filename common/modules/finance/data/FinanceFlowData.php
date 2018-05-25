<?php
/**
 * 充值记录表数据层
 *
 * 如需加REDIS层，在此处添加即可
 * 规则是：1.保存/修改/删除时更新REDIS
 *        2.读取列表时先读取REDIS，如REDIS数据为空，则初始化DB数据入REDIS
 */
namespace common\modules\finance\data;

use common\modules\finance\models\FinanceFlow;
use common\modules\finance\models\FinanceIncome;
use yii\base\BaseObject;

class FinanceFlowData extends BaseObject
{
    //支付方式  1-充值,2-得奖,3-退款,4-提现,5-消费
    public static $target_type = [1=>"充值", 2=>"得奖", 3=>"退款", 4=>"提现", 5=>"消费"];
    const TARGET_TYPE_INCOME = 1;
    const TARGET_TYPE_REWARD = 2;
    const TARGET_TYPE_RETURN = 3;
    const TARGET_TYPE_WITHDRAW = 4;
    const TARGET_TYPE_OUTCOME = 5;

}