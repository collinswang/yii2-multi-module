<?php

namespace common\modules\finance\models;

use Yii;

/**
 * This is the model class for table "finance_account".
 *
 * @property int $uid 用户UID
 * @property string $total_usable 可用金额
 * @property string $total_income 总充值金额
 * @property string $total_award 总得奖金额
 * @property string $total_outcome 总消费金额
 * @property string $total_withdraw 总提现金额
 * @property string $total_return 总退款金额
 * @property int $status 状态:1-正常,0-冻结
 * @property int $admin_id 管理员UID
 * @property string $admin_note 变更理由
 * @property int $last_time 最后更新时间
 */
class FinanceAccount extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'finance_account';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid'], 'required'],
            [['uid', 'status', 'admin_id', 'last_time'], 'integer'],
            [['total_usable', 'total_income', 'total_award', 'total_outcome', 'total_withdraw', 'total_return'], 'number'],
            [['admin_note'], 'string', 'max' => 255],
            [['uid'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'Uid',
            'total_usable' => 'Total Usable',
            'total_income' => 'Total Income',
            'total_award' => 'Total Award',
            'total_outcome' => 'Total Outcome',
            'total_withdraw' => 'Total Withdraw',
            'total_return' => 'Total Return',
            'status' => 'Status',
            'admin_id' => 'Admin ID',
            'admin_note' => 'Admin Note',
            'last_time' => 'Last Time',
        ];
    }
}
