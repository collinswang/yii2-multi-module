<?php

namespace common\modules\sms\models;

use Yii;

/**
 * This is the model class for table "sms_sign".
 *
 * @property int $id
 * @property int $uid
 * @property int $source 签名递交平台:1:QCLOUD
 * @property int $sign_id 签名ID
 * @property string $name 签名
 * @property string $desc 签名描述
 * @property int $create_at
 * @property int $update_at
 * @property int $verify_status 0：已通过；1：待审核；2：已拒绝
 * @property string $verify_desc 审核返回说明
 * @property int $is_hidden 0:不删除 1:删除
 */
class SmsSign extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sms_sign';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'source', 'name', 'create_at'], 'required'],
            [['uid', 'source', 'sign_id', 'create_at', 'update_at', 'verify_status', 'is_hidden'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['desc', 'verify_desc'], 'string', 'max' => 255],
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
            'sign_id' => 'Sign ID',
            'name' => 'Name',
            'desc' => 'Desc',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
            'verify_status' => 'Verify Status',
            'verify_desc' => 'Verify Desc',
            'is_hidden' => 'Is Hidden',
        ];
    }
}
