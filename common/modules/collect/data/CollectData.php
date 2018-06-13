<?php
/**
 *
 * User: cf8
 * Date: 18-6-11
 */

namespace common\modules\collect\data;
use common\modules\collect\models\CollectData as DataCollect;
use common\modules\collect\models\CollectData2 as DataCollect2;

class CollectData
{

    public function add($data)
    {
        if(!$data['name'] || !$data['address'] || !$data['phone']){
            return ['status'=>-1, 'msg'=>'参数不全'];
        }
        $collect = new DataCollect();

        //检查记录是否存在
        $detail = DataCollect::findOne(['url'=>$data['url']]);
        if($detail){
            return ['status'=>-2, 'msg'=>'记录已存在'];
        } else {
            $collect->attributes = $data;
            if($collect->save()){
                return ['status'=>1, 'msg'=>'保存成功', 'id'=>$collect->id];
            } else {
                print_r($collect->getErrors());
                return ['status'=>-3, 'msg'=>'保存失败'];
            }
        }
    }


    public function add2($data)
    {
        if(!$data['name'] || !$data['address'] || !$data['phone']){
            return ['status'=>-1, 'msg'=>'参数不全'];
        }
        $collect = new DataCollect2();

        //检查记录是否存在
        $detail = DataCollect2::findOne(['url'=>$data['url']]);
        if($detail){
            return ['status'=>-2, 'msg'=>'记录已存在'];
        } else {
            $collect->attributes = $data;
            if($collect->save()){
                return ['status'=>1, 'msg'=>'保存成功', 'id'=>$collect->id];
            } else {
                print_r($collect->getErrors());
                return ['status'=>-3, 'msg'=>'保存失败'];
            }
        }
    }
}