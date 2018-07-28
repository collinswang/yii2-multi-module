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
use yii\base\BaseObject;

class SmsTemplateData extends BaseObject
{

    const SEARCH_BY_ID = 1;
    const SEARCH_BY_UID = 2;

    public static $source = [1=>"腾迅云", 2=>"阿里云"];
    const SOURCE_QCLOUD = 1;
    const SOURCE_ALIYUN = 2;

    //$verify_status
    public static $verify_status = [0=>'审核成功', 1=>"审核中", 2=>"审核失败"];
    const VERIFY_STATUS_SUCCESS = 0;
    const VERIFY_STATUS_PENDING = 1;
    const VERIFY_STATUS_FAIL = 2;

    public static $type = [0=>"普通短信", 1=>"营销短信"];
    const TYPE_NORMAL = 0;
    const TYPE_SPREAD = 1;

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

    /**
     * 按页获取模板列表
     * @param     $source
     * @param int $page
     * @param int $page_size
     * @return array
     */
    public function getList($source = 0, $page = 1, $page_size = 20)
    {
        $source = intval($source);
        if($source){
            $sql = "source = ".intval($source);
        } else {
            $sql = "1=1";
        }
        $result = [];
        $list = SmsTemplate::find()->where($sql)->offset(($page-1)*$page_size)->limit($page_size)->asArray()->all();
        if($list){
            foreach ($list as $item) {
                $result[$item['id']] = $item['content'];
            }
        }
        return $result;
    }
}