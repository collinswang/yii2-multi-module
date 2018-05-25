<?php

namespace common\modules\finance\models;

use Yii;

/**
 * This is the model class for table "finance_order".
 *
 * @property int $id
 * @property int $uid UID
 * @property string $item_price 产品单价
 * @property int $item_qty 产品数量
 * @property string $order_amount 订单总金额
 * @property int $coupon_id 优惠券ID
 * @property string $coupon_amount 优惠金额
 * @property string $total_amount 订单实际金额
 * @property int $create_time 订单创建时间
 * @property int $status 状态(1-结算中,2-已结算,3-结算失败)
 * @property int $admin_id 管理员UID
 * @property string $admin_note 管理员备注
 * @property int $invisible 是否可见(1-正常,0-隐藏)
 */
class FinanceOrder extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'finance_order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'item_qty', 'coupon_id', 'create_time', 'status', 'admin_id', 'invisible'], 'integer'],
            [['item_price', 'order_amount', 'coupon_amount', 'total_amount'], 'number'],
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
            'item_price' => 'Item Price',
            'item_qty' => 'Item Qty',
            'order_amount' => 'Order Amount',
            'coupon_id' => 'Coupon ID',
            'coupon_amount' => 'Coupon Amount',
            'total_amount' => 'Total Amount',
            'create_time' => 'Create Time',
            'status' => 'Status',
            'admin_id' => 'Admin ID',
            'admin_note' => 'Admin Note',
            'invisible' => 'Invisible',
        ];
    }
}
