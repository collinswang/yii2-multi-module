<?php
/**
 * SMS签名数据层逻辑
 *
 * 如需加REDIS层，在此处添加即可
 * 规则是：1.保存/修改/删除时更新REDIS
 *        2.读取列表时先读取REDIS，如REDIS数据为空，则初始化DB数据入REDIS
 */
namespace common\modules\sms\data;

use common\modules\finance\data\FinanceFlowData;
use common\modules\finance\models\FinanceFlow;
use common\modules\sms\models\SmsUpload;
use Yii;
use yii\base\BaseObject;

class SmsUploadData extends BaseObject
{

    public static $source = [1=>"腾迅云", 2=>"阿里云"];
    const SOURCE_QCLOUD = 1;
    const SOURCE_ALIYUN = 2;

    /**
     * 添加发送短信记录
     * @param array     $data
     * @return int
     */
    public function add($data)
    {
        $total_money = floatval($data['total']* Yii::$app->params['price_per_sms']);
        if(!$total_money){
            return false;
        }
        $transaction = Yii::$app->db->beginTransaction();
        try{
            $model = new SmsUpload();
            $model->attributes = $data;
            if ($model->save()) {
                //同时扣除用户相应金额
                $flow = new FinanceFlow();
                $flow->uid = $data['uid'];
                $flow->money = -$total_money;   //消费为负数
                $flow->target_type = FinanceFlowData::TARGET_TYPE_OUTCOME;
                $flow->target_id = $data['uid'];
                $flow->create_time = time();
                $flow->invisible = 0;
                if($flow->save()){
                    $flow_id = $flow->id;
                } else {
                    //print_r($flow->getErrors());
                    $transaction->rollBack();
                    return false;
                }
            } else {
                //print_r($model->getErrors());
                $transaction->rollBack();
                return false;
            }
            $transaction->commit();
            return $model->id;
        } catch(\Exception $e){
            //print_r($e->getMessage());
            $transaction->rollBack();
            return false;
        }

    }

    /**
     * 修改短信
     * @param int       $id
     * @param array     $data
     * @return int
     */
    public function update($id, $data)
    {
        $result = SmsUpload::updateAll($data, ['id'=>$id]);
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
        $result = SmsUpload::updateAll($data, ['sid'=>$sid]);
        return $result;
    }

    /**
     * 删除短信
     * @param $id
     * @return int
     */
    public function del($id)
    {
        $result = SmsUpload::updateAll(['is_hidden'=>1], ['id'=>$id]);
        return $result;
    }

    /**
     * 获取列表
     * @param $uid
     * @param int $page
     * @param int $page_size
     * @param $start_time
     * @param $end_time
     * @param $source
     * @return array|\yii\db\ActiveRecord[]
     */
    public function get_list($uid, $page = 1, $page_size = 20, $start_time, $end_time, $source)
    {
        $sql = "is_hidden = 0 and uid = $uid";
        if($start_time){
            $sql .= " and create_at >= {$start_time}";
        }
        if($end_time){
            $sql .= " and create_at < {$end_time}";
        }
        if($source){
            $sql .= " and source = {$source}";
        }
        $result['total'] = SmsUpload::find()->where($sql)->count();
        $result['list'] = SmsUpload::find()->where($sql)->offset(($page-1)*$page_size)->limit($page_size)->orderBy("id desc")->asArray()->all();
        return $result;
    }

    /**
     * 根据主键ID查询详情
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     * @internal param $uid
     * @internal param $mobile
     */
    public function get_detail($id)
    {
        return SmsUpload::find()->where(['id'=>$id])->asArray()->one();
    }
}