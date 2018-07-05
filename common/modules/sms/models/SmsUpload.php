<?php

namespace common\modules\sms\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "sms_upload".
 *
 * @property int $id
 * @property int $uid 用户UID
 * @property int $source 来源：1：腾迅云 2：阿里云
 * @property string $template_id 模板ID
 * @property int $total 操作总数
 * @property int $total_success 成功总数
 * @property int $create_at 创建时间
 * @property int $update_at 更新时间
 * @property int $is_hidden 0:隐藏 1:显示
 */
class SmsUpload extends ActiveRecord
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
        return 'sms_upload';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'source', 'template_id', 'total'], 'required'],
            [['create_at', 'update_at'], 'safe'],
            [['uid', 'source', 'total', 'total_success', 'create_at', 'update_at', 'is_hidden', 'total_success'], 'integer'],
            [['template_id'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => '用户UID',
            'source' => '来源：1：腾迅云 2：阿里云',
            'template_id' => '模板ID',
            'total' => '操作总数',
            'total_success' => '成功总数',
            'create_at' => '创建时间',
            'update_at' => '更新时间',
            'is_hidden' => '0:隐藏 1:显示',
        ];
    }
}
