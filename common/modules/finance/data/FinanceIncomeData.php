<?php
/**
 * 充值记录表数据层
 *
 * 如需加REDIS层，在此处添加即可
 * 规则是：1.保存/修改/删除时更新REDIS
 *        2.读取列表时先读取REDIS，如REDIS数据为空，则初始化DB数据入REDIS
 */
namespace common\modules\finance\data;

use common\modules\finance\models\FinanceFlow;
use common\modules\finance\models\FinanceIncome;
use Exception;
use yii\base\BaseObject;

class FinanceIncomeData extends BaseObject
{
    //支付方式
    public static $type_arr = [1=>"支付宝", 2=>"微信", 3=>"银行"];
    const TYPE_ALIPAY = 1;
    const TYPE_WECHAT = 2;
    const TYPE_OTHER = 3;

    //支付状态
    public static $status_arr = [1=>"支付中", 2=>"成功", 3=>"支付失败", 4=>"退款",];
    const STATUS_PAYING = 1;
    const STATUS_SUCCESS = 2;
    const STATUS_FAIL = 3;
    const STATUS_RETURN = 4;

    //软删除状态
    public static $invisible_arr = [0=>"隐藏", 1=>"正常"];
    const INVISIBLE_FALSE = 0;
    const INVISIBLE_TRUE = 1;

    //手续费
    const FEE_RATE = 0;

    /**
     * 生成充值记录
     * @param array $data
     * @return array
     * @throws \yii\db\Exception
     */
    public function add($data)
    {
        //开启事务
        $db_con = FinanceIncome::getDb()->beginTransaction();
        try {
            if($data['status'] == 2){   //成功时
                $data['deal_time'] = $data['create_time'];
            }
            $result = new FinanceIncome();
            $result->attributes = $data;
            if($result->save()){
                $income_id = $result->id;
            } else {
                //print_r($result->getErrors());
                $db_con->rollBack();
                return ['status'=>-1, 'desc'=>'添加失败'];
            }

            if($income_id && (intval($data['status']) == 2)){
                //新增赢家币流水记录表记录 +
                $result_flow = new FinanceFlow();
                $result_flow->uid = $data['uid'];
                $result_flow->money = $data['received'];
                $result_flow->target_type = FinanceFlowData::TARGET_TYPE_INCOME;
                $result_flow->target_id = $income_id;
                $result_flow->create_time = $data['deal_time'];
                if($result_flow->save()){
                    $flow_id = $result_flow->id;
                } else {
                    //print_r($result->getErrors());
                    $db_con->rollBack();
                    return ['status'=>-2, 'desc'=>'添加流水失败'];
                }
            }
            //提交事务
            $db_con->commit();
            return ['status'=>1, 'desc'=>'添加成功', 'id'=>$income_id];
        } catch (Exception $e) {
            //回滚事务
            $db_con->rollBack();
            //var_dump($e->getMessage());
            return ['status'=>-3, 'desc'=>'事务执行失败'];
        }
    }

    /**
     * 获取单条记录
     * @param array     $data
     * @return array|null|\yii\db\ActiveRecord
     */
    public function get_one($data)
    {
        return FinanceIncome::find()->where($data)->asArray()->one();
    }

    /**
     * 更新充值状态
     * @param        $id
     * @param        $status
     * @param int    $admin_id
     * @param string $admin_note
     * @param int    $deal_time
     * @param        $invisible
     * @return array
     * @throws \yii\db\Exception
     */
    public function update($id, $status, $admin_id = 0, $admin_note="", $deal_time=0, $invisible = 1)
    {
        if(!$id){
            return ['status'=>-1, 'desc'=>'记录无效'];
        }

        if(!in_array($status, array_keys(self::$status_arr))){
            return ['status'=>-2, 'desc'=>'支付状态错误'];
        }

        $income_detail = $this->get_one(['id'=>intval($id)]);
        if(!$income_detail){
            return ['status'=>-1, 'desc'=>'记录无效'];
        }
        if($income_detail['status'] == 2 && $invisible == 1 ){
            return ['status'=>-3, 'desc'=>'已结算记录不允许隐藏'];
        }

        //判断更改支付状态时,如果原状态是支付成功,则不允许改为 支付中 状态
        if(isset($status) && $income_detail['status'] > $status){
            return ['status'=>-4, 'desc'=>'状态不能回退'];
        }

        //组装内容
        $data = array();
        $status && $data['status'] = $status;
        isset($invisible) && $data['invisible'] = $invisible;
        $admin_id && $data['admin_id'] = $admin_id;
        $admin_note && $data['admin_note'] = $admin_note;
        if($deal_time){
            $data['deal_time'] = $deal_time;
        } else {
            //判断原状态!=2且新状态为=2时,才会更新成交时间
            if ($income_detail['status'] < 2 && $status == 2) {
                $data['deal_time'] = time();
            }
        }

        $flow_id = 0;
        //开启事务
        $db_con = FinanceIncome::getDb()->beginTransaction();
        try {
            $result = FinanceIncome::updateAll($data, ['id'=>$id]);
            //没有任何更改
            if(!$result){
                return ['status'=>-11, 'desc'=>'没有任何更改'];
            }
            if(($income_detail['status'] < 2 && $status == 2) && $result){
                //新增流水记录表记录 +
                $result_flow = new FinanceFlow();
                $result_flow->uid = $income_detail['uid'];
                $result_flow->money = $income_detail['received'];
                $result_flow->target_type = FinanceFlowData::TARGET_TYPE_INCOME;
                $result_flow->target_id = $id;
                $result_flow->create_time = $data['deal_time']?$data['deal_time']:time();
                if($result_flow->save()){
                    $flow_id = $result_flow->id;
                } else{
                    //print_r($result_flow->getErrors());
                    $db_con->rollBack();
                    return ['status'=>-13, 'desc'=>'流水记录表保存失败,直接回滚'];
                }

                //如果支付订单与其它消费订单有关联，则更新消费订单的状态，如果更新出错则记录日志
                self::after_success($income_detail['uid'], $id, $income_detail['received']);
            }
            //提交事务
            $db_con->commit();
            return ['status'=>1, 'desc'=>'成功', 'flow_id'=>$flow_id];
        } catch (Exception $e) {
            //回滚事务
            $db_con->rollBack();
            //var_dump($e->getMessage());
            return ['status'=>-14, 'desc'=>'事务执行失败'];
        }
    }

    /**
     * 充值成功后的逻辑
     * @param $uid
     * @param $id
     * @param $money
     */
    public function after_success($uid, $id, $money)
    {

    }

    /**
     * @param $uid
     * @param $page
     * @param $page_size
     * @param $start_time
     * @param $end_time
     */
    public function get_list($uid, $page, $page_size, $start_time, $end_time)
    {
        $sql = "invisible = 1 and status = 2 and uid = {$uid}";
        if($start_time){
            $sql .= " and deal_time >= {$start_time}";
        }
        if($end_time){
            $sql .= " and deal_time < {$end_time}";
        }
        echo $sql,"\r\n";
        $result['total'] = FinanceIncome::find()->where($sql)->count();
        $result['list'] = FinanceIncome::find()->where($sql)->offset(($page-1)*$page_size)->orderBy("id desc")->limit($page_size)->asArray()->all();
        return $result;
    }
}