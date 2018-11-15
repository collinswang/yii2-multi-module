<?php
/**
 * 充值记录表业务层
 * @author collins
 */
namespace common\modules\finance\service;

use common\modules\finance\data\FinanceAccountData;
use common\modules\finance\data\FinanceFlowData;
use yii\base\BaseObject;

class FinanceFlowService extends BaseObject
{

    public function get_list($uid, $page = 1, $page_size = 20, $target_type = null, $start_time = null, $end_time = null)
    {
        $page = intval($page);
        if($target_type && !in_array($target_type, FinanceFlowData::$target_type)){
            return [];
        }
        $start_time && $start_time = intval($start_time);
        $end_time && $end_time = intval($end_time);
        $model = new FinanceFlowData();
        $result = $model->get_list($uid, $page, $page_size, $target_type, $start_time, $end_time);
        if($result['list']){
            $list = [];
            foreach ($result['list'] as $item) {
                $single = [];
                $single['target_type'] = FinanceFlowData::$target_type[$item['target_type']];
                $single['target_id'] = $item['target_id'];
                $single['money'] = $item['money'];
                $single['create_time'] = date("Y-m-d H:i:s", $item['create_time']);
                $list[] = $single;
           }
            $result['list'] = $list;
        }
        $result['total'] = ceil($result['total']/$page_size);
        return $result;

    }

}