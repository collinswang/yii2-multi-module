<?php

namespace common\modules\collect\models;

use Yii;

/**
 * This is the model class for table "collect_data".
 *
 * @property int $id
 * @property string $name
 * @property string $address
 * @property string $phone
 * @property string $url
 * @property int $cityId 城市ID
 * @property string $showType
 * @property string $areaName 区域
 * @property string $cateName 分类
 * @property string $frontImg
 */
class CollectData extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'collect_data';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'address', 'phone'], 'required'],
            [['cityId'], 'integer'],
            [['name', 'address', 'url', 'frontImg'], 'string', 'max' => 255],
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
            'cityId' => 'City ID',
            'showType' => 'Show Type',
            'areaName' => 'Area Name',
            'cateName' => 'Cate Name',
            'frontImg' => 'Front Img',
        ];
    }
}
