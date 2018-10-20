<?php
/**
 * 充值记录表业务层
 * @author collins
 */
namespace common\modules\finance\service;

use common\modules\finance\data\FinanceAccountData;
use yii\base\BaseObject;

class FinanceAccountService extends BaseObject
{

    /**
     * @param $uid
     * @return array|null|\yii\db\ActiveRecord
     */
    public function get_one($uid)
    {
        $uid = intval($uid);
        if(!$uid){
            return [];
        }
        $model = new FinanceAccountData();
        $detail = $model->get_one($uid);
        if(!$detail){
            return [];
        }
        $result = [
            'uid' => $detail['uid'],
            'total_usable' => $detail['total_usable'],
            'total_income' => $detail['total_income'],
            'last_time' => date("Y-m-d H:i:s", $detail['last_time']),
        ];
        return $result;
    }

    /**
     * 检查用户余额是否足够
     * @param $uid
     * @param $total
     * @return bool
     */
    public function check_total_usable($uid, $total)
    {
        $account = $this->get_one($uid);
        if($account && $account['total_usable'] >= $total){
            return true;
        } else {
            return false;
        }
    }


}