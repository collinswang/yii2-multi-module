<?php
/**
 * 充值记录表业务层
 * @author collins
 */
namespace common\modules\finance\service;

use common\modules\finance\data\FinanceIncomeData;
use yii\base\BaseObject;

class FinanceIncomeService extends BaseObject
{

    /**
     * 生成充值记录
     * @param int    $uid         用户UID
     * @param int    $type        支付方式
     * @param int    $status      支付状态
     * @param float  $payable     支付金额
     * @param int    $admin_id    管理员ID
     * @param string $admin_note  管理员备注
     * @param int    $create_time 创建时间
     * @param int    $deal_time   支付时间
     * @param int    $invisible   是否可见
     * @return array
     * @throws \yii\db\Exception
     */
    public function add($uid, $type, $status, $payable, $admin_id = 0, $admin_note ="", $create_time=null, $deal_time=0, $invisible = 1)
    {
        if(!$uid || !$type || !$payable){
            return ['status'=>-1, 'desc'=>'参数错误'];
        }

        if(!in_array($type, array_keys(FinanceIncomeData::$type_arr))){
            return ['status'=>-2, 'desc'=>'支付方式错误'];
        }

        if(!in_array($status, array_keys(FinanceIncomeData::$status_arr))){
            return ['status'=>-3, 'desc'=>'支付状态错误'];
        }

        $data["uid"] = $uid;
        $data["payable"] = floatval($payable);
        $data['fee_rate'] = FinanceIncomeData::FEE_RATE;
        $data['fee'] = (FinanceIncomeData::FEE_RATE * $data["payable"]);
        $data['received'] = number_format($data["payable"]-$data['fee'], 2, '.', '');
        $data['create_time'] = $create_time ? $create_time : time();
        $data['deal_time'] = $deal_time;
        $data['type'] = $type;
        $data['status'] = $status;
        $data['admin_id'] = $admin_id;
        $data['admin_note'] = $admin_note;
        $data['invisible'] = $invisible;

        $model = new FinanceIncomeData();
        $add_result = $model->add($data);

        return $add_result;
    }

    /**
     * 充值记录更新
     * @param int    $id
     * @param int    $status
     * @param int    $admin_id
     * @param string $admin_note
     * @param int    $deal_time
     * @param null   $invisible
     * @return array
     * @throws \yii\db\Exception
     */
    public function update($id, $status, $admin_id = 0, $admin_note="", $deal_time=0, $invisible=null)
    {
        $model = new FinanceIncomeData();
        $update_result = $model->update($id, $status, $admin_id, $admin_note, $deal_time, $invisible);
        return $update_result;
    }

}