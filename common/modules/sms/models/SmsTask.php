<?php

namespace common\modules\sms\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "sms_task".
 *
 * @property int $id
 * @property int $uid 用户UID
 * @property int $source 来源：1：腾迅云 2：阿里云
 * @property int $template_id 模板ID
 * @property int $total 操作总数
 * @property int $total_success 成功总数
 * @property int $create_at 创建时间
 * @property int $update_at 更新时间
 * @property int $is_hidden 1:隐藏 0:显示
 * @property int $status 任务状态:0.待确认 1:已确认执行中 2:执行完成 3:执行失败
 * @property string $file 上传的文件地址
 * @property string $single_price 单条价格,单位:分
 * @property string $total_price 总价格,单位:分
 */
class SmsTask extends ActiveRecord
{

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['create_at', 'update_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['update_at'],
                ],
                // if you're using datetime instead of UNIX timestamp:
                // 'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sms_task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'source', 'template_id', 'file'], 'required'],
            [['uid', 'source', 'template_id', 'total', 'total_success', 'is_hidden', 'status'], 'integer'],
            [['single_price', 'total_price'], 'number'],
            [['file'], 'string', 'max' => 255],
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
            'source' => 'Source',
            'template_id' => 'Template ID',
            'total' => 'Total',
            'total_success' => 'Total Success',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
            'is_hidden' => 'Is Hidden',
            'status' => 'Status',
            'file' => 'File',
            'single_price' => 'Single Price',
            'total_price' => 'Total Price',
        ];
    }
}
