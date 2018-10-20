<?php
/**
 * 充值记录表数据层
 *
 * 如需加REDIS层，在此处添加即可
 * 规则是：1.保存/修改/删除时更新REDIS
 *        2.读取列表时先读取REDIS，如REDIS数据为空，则初始化DB数据入REDIS
 */
namespace common\modules\finance\data;

use common\modules\finance\models\FinanceAccount;
use yii\base\BaseObject;

class FinanceAccountData extends BaseObject
{

    /**
     * 查询帐户信息
     * @param int   $uid
     * @return array|null|\yii\db\ActiveRecord
     */
    public function get_one($uid)
    {
        $detail = FinanceAccount::find()->where("uid = {$uid}")->asArray()->one();
        return $detail;
    }

}