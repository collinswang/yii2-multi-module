<?php

namespace common\modules\sms\models;

use Yii;

/**
 * This is the model class for table "sms_template".
 *
 * @property int $id
 * @property int $uid
 * @property int $source 签名递交平台:1:QCLOUD
 * @property int $template_id 模板ID
 * @property string $content 模板内容
 * @property string $desc 模板说明
 * @property string $title 模板名称
 * @property int $create_at
 * @property int $update_at
 * @property int $verify_status 审核状态：0：已通过；1：待审核；2：已拒绝
 * @property string $verify_desc 审核返回说明
 * @property int $is_hidden 0:不删除 1:删除
 */
class SmsTemplate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sms_template';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'source', 'content', 'create_at'], 'required'],
            [['uid', 'source', 'template_id', 'create_at', 'update_at', 'verify_status', 'is_hidden'], 'integer'],
            [['content', 'desc', 'verify_desc'], 'string', 'max' => 255],
            [['title'], 'string', 'max' => 50],
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
            'source' => 'Source',
            'template_id' => 'Template ID',
            'content' => 'Content',
            'desc' => 'Desc',
            'title' => 'Title',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
            'verify_status' => 'Verify Status',
            'verify_desc' => 'Verify Desc',
            'is_hidden' => 'Is Hidden',
        ];
    }
}
