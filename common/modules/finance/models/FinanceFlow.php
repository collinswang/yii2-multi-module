<?php

namespace common\modules\finance\models;

use Yii;

/**
 * This is the model class for table "finance_flow".
 *
 * @property int $id
 * @property int $uid 用户UID
 * @property string $money 金额,充值/得奖/退款为正数,提现/报名/送礼/购物为负数
 * @property int $target_type 流水类型(1-充值,2-得奖,3-退款,4-提现,5-消费
 * @property int $target_id 以上类型所对应表的主键ID
 * @property int $create_time 创建时间
 * @property int $invisible 是否可见(1-正常,0-隐藏)
 */
class FinanceFlow extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'finance_flow';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'money', 'target_type', 'target_id', 'create_time'], 'required'],
            [['uid', 'target_type', 'target_id', 'create_time', 'invisible'], 'integer'],
            [['money'], 'number'],
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
            'money' => 'Money',
            'target_type' => 'Target Type',
            'target_id' => 'Target ID',
            'create_time' => 'Create Time',
            'invisible' => 'Invisible',
        ];
    }
}
