<?php

namespace common\modules\finance\models;

use Yii;

/**
 * This is the model class for table "finance_withdraw".
 *
 * @property int $id
 * @property int $uid UID
 * @property string $total_amount 金额
 * @property int $create_time 创建时间
 * @property int $status 状态(1-结算中,2-已结算,3-结算失败)
 * @property int $admin_id 管理员UID
 * @property string $admin_note 管理员备注
 * @property int $invisible 是否可见(1-正常,0-隐藏)
 */
class FinanceWithdraw extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'finance_withdraw';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'create_time', 'status', 'admin_id', 'invisible'], 'integer'],
            [['total_amount'], 'number'],
            [['admin_note'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'total_amount' => 'Total Amount',
            'create_time' => 'Create Time',
            'status' => 'Status',
            'admin_id' => 'Admin ID',
            'admin_note' => 'Admin Note',
            'invisible' => 'Invisible',
        ];
    }
}
