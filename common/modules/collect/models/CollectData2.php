<?php

namespace common\modules\collect\models;

use Yii;

/**
 * This is the model class for table "collect_data2".
 *
 * @property int $id
 * @property string $name
 * @property string $address
 * @property string $phone
 * @property string $url
 * @property int $cityid 城市ID
 * @property string $showType
 * @property string $areaName 区域
 * @property string $cateName 分类
 */
class CollectData2 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'collect_data2';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'address', 'phone'], 'required'],
            [['cityid'], 'integer'],
            [['name', 'address', 'url'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 120],
            [['showType', 'areaName', 'cateName'], 'string', 'max' => 20],
            [['url'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'address' => 'Address',
            'phone' => 'Phone',
            'url' => 'Url',
            'cityid' => 'Cityid',
            'showType' => 'Show Type',
            'areaName' => 'Area Name',
            'cateName' => 'Cate Name',
        ];
    }
}
