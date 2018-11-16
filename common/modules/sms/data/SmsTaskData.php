<?php
/**
 * SMS批量发送任务表数据层
 *
 * 流程: 1. 新建任务,保存上传文件
 *      2.确认任务,并执行支付流程,支付成功修改状态为执行中,同时将任务写入REDIS,供异步执行
 *      3.执行完毕,更新任务状态
 *
 * 如需加REDIS层，在此处添加即可
 * 规则是：1.保存/修改/删除时更新REDIS
 *        2.读取列表时先读取REDIS，如REDIS数据为空，则初始化DB数据入REDIS
 */
namespace common\modules\sms\data;

use common\components\Tools;
use common\modules\finance\data\FinanceFlowData;
use common\modules\finance\models\FinanceFlow;
use common\modules\sms\models\SmsTask;
use common\modules\sms\service\SmsService;
use Yii;
use yii\base\BaseObject;

class SmsTaskData extends BaseObject
{

    public static $source = [1=>"腾迅云", 2=>"阿里云"];
    const SOURCE_QCLOUD = 1;
    const SOURCE_ALIYUN = 2;


    /**
     * 保存任务
     * @param $uid
     * @param $template_id
     * @param $file
     * @return array
     */
    public function add($uid, $template_id, $file)
    {

        $template_model = new SmsTemplateData();
        $template_info = $template_model->get(SmsTemplateData::SEARCH_BY_ID, $template_id);
        if(!$template_info && $template_info['status'] == 1 && $template_info['verify_status'] <> 0){
            return ['status'=>-1, 'error'=>'模板不存在', 'id'=>0];
        }

        //分析上传文件,获取总条数和EXAMPLE
        $check_result = $this->check_task_list($template_info, $file);

        $model = new SmsTask();
        $model->uid = $uid;
        $model->template_id = $template_id;
        $model->source = $template_info['source'];
        $model->is_hidden = 0;
        $model->total = $check_result['total'];
        $model->file = $file;
        $model->single_price = Yii::$app->params['price_per_sms'];  //分
        $model->total_price = round($model->single_price * $model->total);

        if($model->save()){
            return ['status'=>1, 'error'=>'', 'id'=>$model->id, 'info'=>$model->attributes, 'list'=>$check_result['list']];
        } else {
            return ['status'=>-2, 'id'=>0, 'error'=>$model->getErrors()];
        }
    }

    /**
     * @param $template_info
     * @param $file
     * @return array
     */
    public function check_task_list($template_info, $file)
    {
        $result = [];
        $success = $fail = $total = $err = 0;
        $sms_list = @file_get_contents($file);
        $sms_list = str_replace(["\r\n", "\r"], "\n", $sms_list);
        $sms_list = explode("\n", $sms_list);
        foreach ($sms_list as $item) {
            if (!$item) {
                continue;
            }
            $item_arr = explode(",", str_replace('"','', $item));
            if (count($item_arr)) {
                $mobile = array_shift($item_arr);
                if(!Tools::check_mobile($mobile)){
                    $err++;
                    continue;
                }
                if ($success< 5 && $mobile) {
                    $result[] = ['mobile'=>$mobile,'content'=>SmsService::buildContentString($template_info, $item_arr)];
                    $success++;
                }
            }
            $total++;
        }

        return ['total'=> $total, 'list' => $result];
    }

    /**
     * 添加发送短信记录
     * @param $uid
     * @param $task_id
     * @return int
     * @throws \yii\db\Exception
     */
    public function confirmTask($uid, $task_id)
    {
        $task = SmsTask::findOne($task_id);
        if(!$task || $task->status){

        }

        $transaction = Yii::$app->db->beginTransaction();
        try{
            $model = new SmsTask();
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
        $result = SmsTask::updateAll($data, ['id'=>$id]);
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
        $result = SmsTask::updateAll($data, ['sid'=>$sid]);
        return $result;
    }

    /**
     * 删除短信
     * @param $id
     * @return int
     */
    public function del($id)
    {
        $result = SmsTask::updateAll(['is_hidden'=>1], ['id'=>$id]);
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
        $result['total'] = SmsTask::find()->where($sql)->count();
        $result['list'] = SmsTask::find()->where($sql)->offset(($page-1)*$page_size)->limit($page_size)->orderBy("id desc")->asArray()->all();
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
        return SmsTask::find()->where(['id'=>$id])->asArray()->one();
    }
}