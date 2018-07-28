<?php

namespace common\modules\finance\models;

use Yii;

/**
 * This is the model class for table "finance_income".
 *
 * @property int $id
 * @property int $uid 用户UID
 * @property string $payable 交易金额
 * @property string $fee_rate 手续费率%
 * @property string $fee 税费金额
 * @property string $received 到帐金额
 * @property int $create_time 添加时间
 * @property int $deal_time 支付时间
 * @property int $type 支付方式(1-支付宝,2-微信支付,3-手动充值)
 * @property int $status 支付状态(1-支付中, 2-成功,3-支付失败,4-退款)
 * @property int $admin_id 管理员UID
 * @property string $admin_note 管理员备注
 * @property int $invisible 是否可见(1-正常,0-隐藏)
 */
class FinanceIncome extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'finance_income';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'create_time', 'deal_time', 'type', 'status', 'admin_id', 'invisible'], 'integer'],
            [['payable', 'fee_rate', 'fee', 'received'], 'number'],
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
            'payable' => 'Payable',
            'fee_rate' => 'Fee Rate',
            'fee' => 'Fee',
            'received' => 'Received',
            'create_time' => 'Create Time',
            'deal_time' => 'Deal Time',
            'type' => 'Type',
            'status' => 'Status',
            'admin_id' => 'Admin ID',
            'admin_note' => 'Admin Note',
            'invisible' => 'Invisible',
        ];
    }
}
