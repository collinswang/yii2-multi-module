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

class FinanceOrderData extends BaseObject
{
    public static $status_arr = [1=>'结算中', 2=>'已结算', 3=>'结算失败'];
    const STATUS_PENDING = 1;
    const STATUS_SUCCESS = 2;
    const STATUS_FAIL = 3;

    public static $invisible_arr = [0=>'隐藏', 1=>'正常']; //1-正常,0-隐藏
    const INVISIBLE_HIDDEN = 0;
    const INVISIBLE_SHOW = 1;
}