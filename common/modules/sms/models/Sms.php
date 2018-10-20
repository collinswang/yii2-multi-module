<?php

namespace common\modules\sms\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "sms".
 *
 * @property int $id
 * @property int $uid 用户UID
 * @property int $source 来源：1：腾迅云 2：阿里云
 * @property int $type 发送类型0:直接发送 1:模板发送
 * @property int $mobile 手机号
 * @property string $template_id 模板ID
 * @property string $content 发送内容
 * @property int $create_at
 * @property int $update_at
 * @property int $send_status 发送结果
 * @property string $send_desc 发送结果说明
 * @property int $is_hidden 0:不删除 1:删除
 * @property int $sid 发送回执ID
 * @property int $order_id
 * @property int $upload_id 批量上传ID
 */
class Sms extends \yii\db\ActiveRecord
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
        return 'sms';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'mobile', 'content'], 'required'],
            [['create_at', 'update_at'], 'safe'],
            [['uid', 'source', 'type', 'create_at', 'update_at', 'send_status', 'is_hidden', 'sid', 'order_id', 'upload_id'], 'integer'],
            [['mobile'], 'string', 'max' => 11],
            [['template_id'], 'string', 'max' => 30],
            [['content', 'send_desc'], 'string', 'max' => 255],
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
            'type' => 'Type',
            'mobile' => 'Mobile',
            'template_id' => 'Template ID',
            'content' => 'Content',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
            'send_status' => 'Send Status',
            'send_desc' => 'Send Desc',
            'is_hidden' => 'Is Hidden',
            'sid' => 'Sid',
            'order_id' => 'Order ID',
            'upload_id' => '批量上传ID',
        ];
    }
}
