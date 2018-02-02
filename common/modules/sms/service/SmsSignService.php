<?php
/**
 * SMS签名业务层逻辑
 */
namespace common\modules\sms\service;

use common\modules\sms\base\QcloudSmsSignService;
use common\modules\sms\data\SmsSignData;
use Yii;

class SmsSignService
{

    /**
     * 新增签名
     * @param int       $uid        用户UID
     * @param string    $sign       签名
     * @param string    $desc       签名说明
     * @return array
     */
    public function add($uid, $sign, $desc)
    {
        if (!$uid) {
            return ['status'=>-1, 'desc'=>'UID不能为空'];
        }
        if (empty($sign)) {
            return ['status'=>-2, 'desc'=>'签名不能为空'];
        }
        $model = new SmsSignData();
        $id = $model->add(['uid'=>$uid,'name'=>$sign, 'desc'=>$desc, 'source'=>1, 'sign_id'=>0, 'create_at'=>time()]);
        if($id){
            $post = new QcloudSmsSignService();
            $post_result = $post->add($sign, $desc);
            $model->update($id, [
                'sign_id'       => $post_result['data']['id'] ? $post_result['data']['id'] : 0,
                'verify_status' => $post_result['data']['status'] ? $post_result['data']['status'] : 0,
                'verify_desc'   => $post_result['msg']? $post_result['msg'] : '',
                'update_at'   => time(),
            ]);
            return ['id' => $id];
        }
        return ['id' => 0];
    }


    public function update($id, $sign_id, $sign, $desc)
    {
        //数据安全性检查
        $id = intval($id);
        $sign_id = intval($sign_id);
        if($id <= 0 || $sign_id <= 0){
            return  ['status'=>-1, 'desc'=>'签名ID不能为空'];
        }
        $sign = trim($sign);
        if(empty($sign)){
            return  ['status'=>-1, 'desc'=>'签名ID不能为空'];
        }
        //存DB
        $model = new SmsSignData();
        $total = $model->update($id, ['sign_id'=>$sign_id,'name'=>$sign, 'desc'=>$desc, 'update_at'=>time()]);
        //提交到指定平台
        if($total){
            $post = new QcloudSmsSignService();
            $post_result = $post->add($sign, $desc);
            //更新提交结果
            $model->update($id, [
                'sign_id'       => $post_result['data']['id'] ? $post_result['data']['id'] : 0,
                'verify_status' => $post_result['data']['status'],
                'verify_desc'   => $post_result['msg'],
                'update_at'   => $post_result['msg'],
            ]);
            return ['id' => $id];
        }
    }


    public function del($sign_id)
    {
        //数据安全性检查
        //存DB
        //提交到指定平台
        //更新提交结果
    }


    public function check($sign_id)
    {
        //数据安全性检查
        //存DB
        //提交到指定平台
        //更新提交结果
    }
}