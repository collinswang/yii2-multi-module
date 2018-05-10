<?php
/**
 * SMS模板数据层逻辑
 *
 * 如需加REDIS层，在此处添加即可
 * 规则是：1.保存/修改/删除时更新REDIS
 *        2.读取列表时先读取REDIS，如REDIS数据为空，则初始化DB数据入REDIS
 */
namespace common\modules\sms\data;

use common\modules\sms\models\SmsSign;
use common\modules\sms\models\SmsTemplate;
use Yii;

class SmsTemplateData
{

    const SEARCH_BY_ID = 1;
    const SEARCH_BY_UID = 2;

    /**
     * 创建签名
     * @param array     $data
     * @return int
     */
    public function add($data)
    {
        $model = new SmsTemplate();
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
        $result = SmsTemplate::updateAll($data, ['id'=>$id]);
        return $result;
    }

    /**
     * 删除签名
     * @param $id
     * @return int
     */
    public function del($id)
    {
        $result = SmsTemplate::updateAll(['is_hidden'=>1], ['id'=>$id]);
        return $result;
    }

    /**
     * 获取详情
     * @param int       $type 1:按ID查找 2：按UID查找
     * @param array|int $key
     * @param int       $page
     * @param int       $page_size
     * @return array
     */
    public function get($type, $key = null, $page = 1, $page_size = 20)
    {
        $detail = array();
        switch($type){
            case 1:
                if (is_array($key)) {
                    $detail = SmsTemplate::find()->where("id in (".implode(",", $key).")")->offset($page_size*($page-1))->limit($page_size)->orderBy("create_at desc")->asArray()->all();
                } elseif(intval($key)) {
                    $detail = SmsTemplate::find()->where("id =".intval($key))->asArray()->one();
                } else {
                    $detail = SmsTemplate::find()->offset($page_size*($page-1))->limit($page_size)->asArray()->all();
                }
                break;
            case 2:
                if (is_array($key)) {
                    $detail = SmsTemplate::find()->where("uid in (".implode(",", $key).")")->offset($page_size*($page-1))->limit($page_size)->orderBy("create_at desc")->asArray()->all();
                } elseif(intval($key)) {
                    $detail = SmsTemplate::find()->where("uid =".intval($key))->offset($page_size*($page-1))->limit($page_size)->orderBy("create_at desc")->asArray()->all();
                } else {
                    $detail = SmsTemplate::find()->offset($page_size*($page-1))->limit($page_size)->asArray()->all();
                }
                break;
        }

        return $detail;
    }


    /**
     * 根据主键ID及用户UID查询记录
     * @param $uid
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     */
    public function check($uid, $id)
    {
        return SmsTemplate::find()->where(['id'=>$id, 'uid'=>$uid])->asArray()->one();
    }
}