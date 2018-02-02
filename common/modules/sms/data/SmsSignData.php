<?php
/**
 * SMS签名数据层逻辑
 *
 * 如需加REDIS层，在此处添加即可
 * 规则是：1.保存/修改/删除时更新REDIS
 *        2.读取列表时先读取REDIS，如REDIS数据为空，则初始化DB数据入REDIS
 */
namespace common\modules\sms\data;

use common\modules\sms\models\SmsSign;
use Yii;

class SmsSignData
{

    /**
     * 创建签名
     * @param array     $data
     * @return int
     */
    public function add($data)
    {
        $model = new SmsSign();
        $model->attributes = $data;
        if ($model->save()) {
            return $model->id;
        } else {
            var_dump($model->getErrors());
            return false;
        }
    }

    /**
     * 修改签名
     * @param bool       $id
     * @param array|null $data
     * @return int
     */
    public function update($id, $data)
    {
        $result = SmsSign::updateAll($data, ['id'=>$id]);
        return $result;
    }

    /**
     * 删除签名
     * @param $id
     * @return int
     */
    public function del($id)
    {
        $result = SmsSign::updateAll(['is_hidden'=>1], ['id'=>$id]);
        return $result;
    }

    /**
     * 获取详情
     * @param int       $type 1:按ID查找 2：按UID查找
     * @param array|int $key
     * @param int       $page
     * @param int       $page_size
     * @return array|\yii\db\ActiveRecord[]
     */
    public function get($type, $key, $page = 1, $page_size = 20)
    {
        $detail = array();
        switch($type){
            case 1:
                if (is_array($key)) {
                    $detail = SmsSign::find()->where("id in (".implode(",", $key).")")->offset($page_size*($page-1))->limit($page_size)->orderBy("create_at desc")->asArray()->all();
                } else {
                    $detail = SmsSign::find()->where("id = $key")->asArray()->all();
                }
                break;
            case 2:
                if (is_array($key)) {
                    $detail = SmsSign::find()->where("uid in (".implode(",", $key).")")->offset($page_size*($page-1))->limit($page_size)->orderBy("create_at desc")->asArray()->all();
                } else {
                    $detail = SmsSign::find()->where("uid = $key")->offset($page_size*($page-1))->limit($page_size)->orderBy("create_at desc")->asArray()->all();
                }
                break;
        }

        return $detail;
    }
}