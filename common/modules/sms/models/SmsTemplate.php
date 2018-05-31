<?php

namespace common\modules\sms\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "sms_template".
 *
 * @property int $id
 * @property int $uid
 * @property int $source 签名递交平台:1:QCLOUD
 * @property string $template_id 模板ID
 * @property string $content 模板内容
 * @property string $desc 模板说明
 * @property string $title 模板名称
 * @property int $created_at
 * @property int $updated_at
 * @property int $verify_status 审核状态：0：已通过；1：待审核；2：已拒绝
 * @property string $verify_desc 审核返回说明
 * @property int $is_hidden 0:不删除 1:删除
 * @property int $type 0:普通短信 1:营销短信
 */
class SmsTemplate extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sms_template';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'source', 'content'], 'required'],
            [['uid', 'source', 'verify_status', 'is_hidden', 'type'], 'integer'],
            [['template_id'], 'string', 'max' => 20],
            [['create_at', 'updated_at'], 'safe'],
            [['content', 'desc', 'verify_desc'], 'string', 'max' => 255],
            [['title'], 'string', 'max' => 50],
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
            'content' => 'Content',
            'desc' => 'Desc',
            'title' => 'Title',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'verify_status' => 'Verify Status',
            'verify_desc' => 'Verify Desc',
            'is_hidden' => 'Is Hidden',
            'type' => 'Type',
        ];
    }
}
