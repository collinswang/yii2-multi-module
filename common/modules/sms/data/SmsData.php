<?php
/**
 * SMS签名数据层逻辑
 *
 * 如需加REDIS层，在此处添加即可
 * 规则是：1.保存/修改/删除时更新REDIS
 *        2.读取列表时先读取REDIS，如REDIS数据为空，则初始化DB数据入REDIS
 */
namespace common\modules\sms\data;

use common\modules\sms\models\Sms;
use Yii;
use yii\db\Exception;

class SmsData
{

    const SEARCH_BY_ID = 1;
    const SEARCH_BY_UID = 2;

    /**
     * 添加发送短信记录
     * @param array     $data
     * @return int
     */
    public function add($data)
    {
        $model = new Sms();
        $model->attributes = $data;
        if ($model->save()) {
            return $model->id;
        } else {
            var_dump($model->getErrors());
            return false;
        }
    }

    /**
     * 批量添加发送短信记录
     * @param array     $data
     * @return int
     */
    public function batch_add($data)
    {
        try {
            Yii::$app->db->createCommand()->batchInsert('sms', ['name', 'age'], $data)->execute();
        } catch (Exception $e) {
        }

        return 1;
    }

    /**
     * 修改签名
     * @param bool       $id
     * @param array|null $data
     * @return int
     */
    public function update($id, $data)
    {
        $result = Sms::updateAll($data, ['id'=>$id]);
        return $result;
    }

    /**
     * 删除签名
     * @param $id
     * @return int
     */
    public function del($id)
    {
        $result = Sms::updateAll(['is_hidden'=>1], ['id'=>$id]);
        return $result;
    }

    /**
     * 获取详情
     * @param           $uid
     * @param int       $type 1:按ID查找 2：按手机号查找
     * @param array|int $key
     * @param int       $page
     * @param int       $page_size
     * @return array|\yii\db\ActiveRecord[]
     */
    public function get($uid, $type, $key = null, $page = 1, $page_size = 20)
    {
        $detail = array();
        switch($type){
            case 1:
                if (is_array($key)) {
                    $detail = Sms::find()->where("uid = {$uid} and id in (".implode(",", $key).")")->offset($page_size*($page-1))->limit($page_size)->orderBy("create_at desc")->asArray()->all();
                } elseif(intval($key)) {
                    $detail = Sms::find()->where("uid = {$uid} and id =".intval($key))->asArray()->one();
                } else {
                    $detail = Sms::find()->where("uid = {$uid}")->offset($page_size*($page-1))->limit($page_size)->asArray()->all();
                }
                break;
            case 2:
                if (is_array($key)) {
                    $detail = Sms::find()->where("uid = {$uid} and mobile in (".implode(",", $key).")")->offset($page_size*($page-1))->limit($page_size)->orderBy("create_at desc")->asArray()->all();
                } elseif(intval($key)) {
                    $detail = Sms::find()->where("uid = {$uid} and mobile =".intval($key))->offset($page_size*($page-1))->limit($page_size)->orderBy("create_at desc")->asArray()->all();
                } else {
                    $detail = Sms::find()->where("uid = {$uid}")->offset($page_size*($page-1))->limit($page_size)->asArray()->all();
                }
                break;
        }

        return $detail;
    }

    /**
     * 根据手机及用户UID查询记录
     * @param $uid
     * @param $mobile
     * @return array|null|\yii\db\ActiveRecord
     */
    public function check($uid, $mobile)
    {
        return Sms::find()->where(['mobile'=>$mobile, 'uid'=>$uid])->asArray()->one();
    }
}