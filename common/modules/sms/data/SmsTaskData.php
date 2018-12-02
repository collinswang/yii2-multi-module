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
use common\events\SmsTaskEvent;
use common\modules\finance\data\FinanceAccountData;
use common\modules\finance\data\FinanceFlowData;
use common\modules\finance\data\FinanceOrderData;
use common\modules\finance\models\FinanceFlow;
use common\modules\finance\models\FinanceOrder;
use common\modules\finance\service\FinanceAccountService;
use common\modules\sms\models\SmsTask;
use common\modules\sms\service\SmsService;
use Yii;
use yii\base\BaseObject;
use yii\base\Event;

class SmsTaskData extends BaseObject
{
    const TASK_QUEUE = 'RL.SMS.TASK';

    //EVENT
    const EVENT_CONFIRM_TASK = 1;

    const EVENT_PROCESS_TASK = 2;

    public static $source = [1=>"腾迅云", 2=>"阿里云"];
    const SOURCE_QCLOUD = 1;
    const SOURCE_ALIYUN = 2;

    //任务状态:0.待确认 1:已确认执行中 2:执行完成 3:执行失败
    public static $status_arr=[
        0=>'待确认',
        1=>'已确认,发送中',
        2=>'发送完成',
        3=>'发送失败',
    ];

    const STATUS_PEDING = 0;
    const STATUS_CONFIRM = 1;
    const STATUS_SUCCESS = 2;
    const STATUS_FAIL = 3;

    const TYPE_TEMPLATE = 1;
    const TYPE_DIRECT = 0;

    /**
     * 保存任务
     * @param $uid
     * @param $template_id
     * @param $file
     * @return array
     */
    public function add($uid, $template_id, $file)
    {

        //分析上传文件,获取总条数和EXAMPLE
        $check_result = $this->check_task_list($template_id, $file);
        if($check_result['status'] <=0){
            return ['status'=>-1, 'error'=>'模板不存在', 'id'=>0];
        }

        $price_per_sms = Yii::$app->params['price_per_sms'];
        $model = new FinanceAccountData();
        $finance = $model->get_one($uid);
        $price_grade_list = Yii::$app->params['price_grade'];
        foreach ($price_grade_list as $key => $item) {
            if(abs($finance['total_outcome']) > $key){
                $price_per_sms = $item;
            }
        }

        $model = new SmsTask();
        $model->uid = $uid;
        $model->template_id = $template_id;
        $model->source = $check_result['template']['source'];
        $model->is_hidden = 0;
        $model->total = $check_result['total'];
        $model->file = $file;
        $model->single_price = $price_per_sms;  //分
        $model->total_price = round($model->single_price * $model->total);

        if($model->save()){
            return ['status'=>1, 'error'=>'', 'id'=>$model->id, 'info'=>$model->attributes, 'list'=>$check_result['list']];
        } else {
            return ['status'=>-2, 'id'=>0, 'error'=>$model->getErrors()];
        }
    }

    /**
     * 检查提交的任务,返回总数量及前几条发送内容
     * @param $template_id
     * @param $file
     * @return array
     */
    public function check_task_list($template_id, $file)
    {

        $template_model = new SmsTemplateData();
        $template_info = $template_model->get(SmsTemplateData::SEARCH_BY_ID, $template_id);
        if(!$template_info && $template_info['status'] == 1 && $template_info['verify_status'] <> 0){
            return ['status'=>-1, 'msg'=>'模板不存在'];
        }

        $result = [];
        $success = $fail = $total = $err = 0;
        $sms_list = @file_get_contents(yii::getAlias('@sms_dir/').$file);
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

        return ['status'=>1, 'msg'=>'ok', 'total'=> $total, 'list' => $result, 'template'=>$template_info];
    }

    /**
     * 确认执行任务:  扣款并写入异步队列
     * @param $task_id
     * @return array
     * @throws \yii\db\Exception
     */
    public function confirmTask($task_id)
    {
        $task = SmsTask::findOne($task_id);
        $task->on(self::EVENT_CONFIRM_TASK, [$this, 'setTaskQueue'], ['task_id' =>$task_id]);

        if(!$task || $task->status){
            return ['status'=>-1, 'msg'=>'task not exists'];
        }

        $service_account = new FinanceAccountService();
        $is_allow = $service_account->check_total_usable($task->uid, $task->total_price/100);
        //余额不足
        if(!$is_allow){
            return ['status'=>-5, 'msg'=>"余额不足，请及时充值"];
        }

        $transaction = Yii::$app->db->beginTransaction();
        try{
            $task->status = self::STATUS_CONFIRM;
            if ($task->save()) {
                //创建订单
                $order = new FinanceOrder();
                $order->uid = $task->uid;
                $order->item_price = $task->single_price;   //分
                $order->item_qty = $task->total;
                $order->order_amount = number_format($task->total_price/100, 2, '.', '');   //元
                $order->coupon_amount = 0;  //元
                $order->coupon_id = 0;
                $order->total_amount = number_format($order->order_amount - $order->coupon_amount, 2, '.', '');
                $order->status = FinanceOrderData::STATUS_SUCCESS;
                $order->invisible = FinanceOrderData::INVISIBLE_SHOW;
                if($order->save()){
                    //同时扣除用户相应金额
                    $flow = new FinanceFlow();
                    $flow->uid = $task->uid;
                    $flow->money = -$task->total_price/100;   //消费为负数
                    $flow->target_type = FinanceFlowData::TARGET_TYPE_OUTCOME;
                    $flow->target_id = $task->id;
                    $flow->create_time = time();
                    $flow->invisible = FinanceFlowData::INVISIBLE_SHOW;
                    if($flow->save()){
                        $flow_id = $flow->id;
                    } else {
                        //print_r($flow->getErrors());
                        $transaction->rollBack();
                        return ['status'=>-2, 'msg'=>$flow->getErrors()];
                    }
                } else {
                    //print_r($order->getErrors());
                    $transaction->rollBack();
                    return ['status'=>-3, 'msg'=>$task->getErrors()];
                }
            } else {
                //print_r($model->getErrors());
                $transaction->rollBack();
                return ['status'=>-3, 'msg'=>$task->getErrors()];
            }
            $transaction->commit();

            $task->trigger(self::EVENT_CONFIRM_TASK);

            return ['status'=>1, 'msg'=>'success', 'id'=>$task->id];
        } catch(\Exception $e){
            //print_r($e->getMessage());
            //throwException(new \Exception('task confirm transaction running fail'));
            $transaction->rollBack();
            return ['status'=>-4, 'msg'=>$e->getMessage()];
        }

    }

    /**
     * 写入队列
     * @param $event
     */
    public function setTaskQueue($event)
    {
        Yii::$app->redis->executeCommand('LPUSH', [self::TASK_QUEUE, $event->data['task_id']]);
    }

    /**
     * 读取队列
     * @return int
     */
    public function getTaskQueue()
    {
        $task_id = Yii::$app->redis->executeCommand('RPOP', [self::TASK_QUEUE]);
        if($task_id){
            return $task_id;
        } else {
            return 0;
        }
    }

    /**
     * 批量入库并入发送队列
     * @param $task_id
     * @return array
     */
    public function processTaskQueue($task_id)
    {
        $task = SmsTask::findOne($task_id);

        //已确认
        if($task->status == 1 && $task->file){

            $template_model = new SmsTemplateData();
            $template_info = $template_model->get(SmsTemplateData::SEARCH_BY_ID, $task->template_id);
            if(!$template_info && $template_info['status'] == 1 && $template_info['verify_status'] <> 0){
                return ['status'=>-2, 'msg'=>'模板不存在'];
            }

            $success = $fail = $total = $err = 0;
            $sms_list = @file_get_contents(yii::getAlias('@sms_dir/').$task->file);
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

                    //生成
                    $build_result = SmsService::buildContent($template_info, $item_arr);
                    if ($build_result['status'] <= 0) {
                        $err++;
                        continue;
                    }

                    //获取
                    $model = new SmsData();
                    $id = $model->add(['uid'         => $task->uid,
                                       'source'        => $template_info['source'],
                                       'type'        => self::TYPE_TEMPLATE,
                                       'template_id' => $template_info['template_id'],
                                       'mobile'      => $mobile,
                                       'content'     => json_encode($build_result['content']),  //param item
                                       'create_at'   => time(),
                                       'task_id'   => $task->id,
                    ]);

                    if ($id) {
                        $success++;
                    } else {
                        $err++;
                    }
                }
                $total++;
            }

            $updates = ['total'=>$total, 'status'=>self::STATUS_SUCCESS];

            $result = SmsTask::updateAll($updates, ['id'=>$task_id]);

            return ['status'=>1, 'msg'=>'success', 'total'=>$total, 'success'=>$success, 'err'=>$err];
        } else {
            return ['status'=>-1, 'msg'=>'任务状态错误或没有文件'];
        }
    }

}