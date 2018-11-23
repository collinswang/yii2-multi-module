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
use yii\base\BaseObject;
use yii\db\Exception;

class SmsData extends BaseObject
{

    const SEARCH_BY_ID = 1;
    const SEARCH_BY_UID = 2;

    public static $source = [0=>"未知渠道", 1=>"腾迅云", 2=>"阿里云"];
    const SOURCE_QCLOUD = 1;
    const SOURCE_ALIYUN = 2;

    public static $send_status = [0=>"发送成功", 1=>"发送中", 2=>'发送失败'];
    const SEND_SUCCESS = 0;
    const SENDING = 1;
    const SEND_FAIL = 2;

    public static $type = [0=>"直接发送", 1=>"模板发送"];
    const TYPE_DIRECT = 0;
    const TYPE_TEMPLATE = 1;

    const QUEUE_KEY = 'SMS.QUEUE.LIST';

    private $redis_con;

    private function Redis(){
        $this->redis_con==null && $this->redis_con = Yii::$app->redis;;
        return $this->redis_con;
    }

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
            //写入队列
            $this->setQueue($model->attributes);
            return $model->id;
        } else {
            print_r($model->getErrors());
            return false;
        }
    }

    /**
     * 写入短信发送队列
     * @param $data
     */
    public function setQueue($data)
    {
        $this->Redis()->executeCommand('LPUSH', [self::QUEUE_KEY, json_encode($data)]);
    }

    /**
     * 写入短信发送队列
     * @return array|mixed
     */
    public function getQueue()
    {
        $data = $this->Redis()->executeCommand('RPOP', [self::QUEUE_KEY]);
        if($data){
            $data = json_decode($data, true);
        } else {
            $data = [];
        }
        return $data;
    }

    /**
     * 修改短信
     * @param int       $id
     * @param array     $data
     * @return int
     */
    public function update($id, $data)
    {
        $result = Sms::updateAll($data, ['id'=>$id]);
        return $result;
    }

    /**
     * 修改短信
     * @param int       $sid
     * @param array|null $data
     * @return int
     */
    public function updateStatus($sid, $data)
    {
        $result = Sms::updateAll($data, ['sid'=>$sid]);
        return $result;
    }

    /**
     * 删除短信
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

    //推荐队列KEY
    CONST SMS_LIST_KEY = "sms_list_key";

    /**
     * 设置推荐队列
     * @param $id
     */
    public function setSmsList($id)
    {
        $redis = Yii::$app->redis;
        $redis->executeCommand("RPUSH", [self::SMS_LIST_KEY, $id]);
    }

    /**
     * 读取队列
     */
    public function getSmsList()
    {
        $redis = Yii::$app->redis;
        return $redis->executeCommand("LPOP", [self::SMS_LIST_KEY]);
    }

    /**
     * 按页查找短信发送记录
     * @param $uid
     * @param int $page
     * @param $upload_id
     * @param int $page_size
     * @param int $start_time
     * @param int $end_time
     * @param $source
     * @param $mobile
     * @param null $send_status
     * @return mixed
     */
    public function getSmsSendList($uid, $page=1, $upload_id, $page_size=20, $start_time=0, $end_time=0, $source = null, $mobile = null, $send_status = null)
    {
        $sql = "uid = {$uid}";
        if($start_time){
            $sql .= " and create_at >= {$start_time}";
        }
        if($end_time){
            $sql .= " and create_at < {$end_time}";
        }
        if($source){
            $sql .= " and source = {$source}";
        }
        if($mobile){
            $sql .= " and mobile = {$mobile}";
        }
        if($send_status){
            $sql .= " and send_status = {$send_status}";
        }
        if($upload_id){
            $sql .= " and upload_id = {$upload_id}";
        }

        $result['total'] = Sms::find()->where($sql)->count();
        $result['list'] = Sms::find()->where($sql)->offset(($page-1)*$page_size)->limit($page_size)->asArray()->all();
        return $result;
    }
}