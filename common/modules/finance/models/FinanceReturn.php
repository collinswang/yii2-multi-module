<?php

namespace common\modules\finance\models;

use Yii;

/**
 * This is the model class for table "finance_return".
 *
 * @property int $id
 * @property int $uid UID
 * @property int $order_id 订单ID
 * @property int $sms_id 短信发送ID
 * @property string $item_price 单价
 * @property int $item_qty 数量
 * @property string $total_amount 总金额
 * @property int $create_time 创建时间
 * @property int $status 状态(1-结算中,2-已结算,3-结算失败)
 * @property int $admin_id 管理员UID
 * @property string $admin_note 管理员备注
 * @property int $invisible 是否可见(1-正常,0-隐藏)
 */
class FinanceReturn extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'finance_return';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'order_id', 'sms_id', 'item_qty', 'create_time', 'status', 'admin_id', 'invisible'], 'integer'],
            [['item_price', 'total_amount'], 'number'],
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
            'order_id' => 'Order ID',
            'sms_id' => 'Sms ID',
            'item_price' => 'Item Price',
            'item_qty' => 'Item Qty',
            'total_amount' => 'Total Amount',
            'create_time' => 'Create Time',
            'status' => 'Status',
            'admin_id' => 'Admin ID',
            'admin_note' => 'Admin Note',
            'invisible' => 'Invisible',
        ];
    }
}
