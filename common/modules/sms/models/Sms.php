<?php

namespace common\modules\sms\models;

use Yii;

/**
 * This is the model class for table "sms".
 *
 * @property int $id
 * @property int $uid 用户UID
 * @property int $type 发送类型0:直接发送 1:模板发送
 * @property int $mobile 手机号
 * @property int $template_id 模板ID
 * @property string $content 发送内容
 * @property int $create_at
 * @property int $update_at
 * @property int $send_status 发送结果
 * @property string $send_desc 发送结果说明
 * @property int $is_hidden 0:不删除 1:删除
 */
class Sms extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sms';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'mobile', 'content', 'create_at'], 'required'],
            [['uid', 'type', 'mobile', 'template_id', 'create_at', 'update_at', 'send_status', 'is_hidden'], 'integer'],
            [['content', 'send_desc'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'type' => 'Type',
            'mobile' => 'Mobile',
            'template_id' => 'Template ID',
            'content' => 'Content',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
            'send_status' => 'Send Status',
            'send_desc' => 'Send Desc',
            'is_hidden' => 'Is Hidden',
        ];
    }
}
