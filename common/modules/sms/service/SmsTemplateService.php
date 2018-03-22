<?php
/**
 * SMS签名业务层逻辑
 */
namespace common\modules\sms\service;

use common\modules\sms\base\SmsTemplateInterface;
use common\modules\sms\data\SmsSignData;

class SmsTemplateService
{
    const SMS_SIGN_API_QCLOUD = 1;
    const SMS_SIGN_API_ALIDAYU = 2;
    protected static $sms_sign_api = [
        1 => 'common\modules\sms\base\QcloudSmsTemplateService',
        2 => 'common\modules\sms\base\AliDayuSmsTemplateService',
    ];

    public static function get_sms_sign_api()
    {
        return self::$sms_sign_api;
    }

    protected $model_sign = '';

    public function __construct($model_sign)
    {
        if(!$model_sign instanceof SmsTemplateInterface){
            return ['status'=>-1, 'desc'=>'传入非 SmsTemplateInterface 的实例'];
        } else {
            $this->model_sign = $model_sign;
        }

        return true;
    }

    /**
     * 新增签名
     * @param int    $uid  用户UID
     * @param string $sign 签名
     * @param string $desc 签名说明
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
        //添加本地签名记录
        $model = new SmsSignData();
        $id = $model->add(['uid'=>$uid,'name'=>$sign, 'desc'=>$desc, 'source'=>1, 'sign_id'=>0, 'create_at'=>time()]);
        if($id){
            //调用API接口提交数据
            $post_result = $this->model_sign->add($sign, $desc);
            //更新本地签名记录，保存API接口返回结果
            $result = $model->update($id, [
                'sign_id'       => $post_result['data']['id'] ? $post_result['data']['id'] : 0,
                'verify_status' => $post_result['result'] ? $post_result['result'] : 0,
                'verify_desc'   => $post_result['msg']? $post_result['msg'] : '',
                'update_at'   => time(),
            ]);
            if($post_result['data']['id'] && $result){
                return ['status'=>1, 'desc'=>'添加成功', 'id' => $id];
            } else {
                return ['status'=>1, 'desc'=>'添加成功，同步失败', 'id' => $id];
            }
        }
        return ['status'=>-1, 'desc'=>'添加失败'];
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
            $post_result = $this->model_sign->add($sign, $desc);
            //更新提交结果
            $result = $model->update($id, [
                'sign_id'       => $post_result['data']['id'] ? $post_result['data']['id'] : 0,
                'verify_status' => $post_result['data']['status'] ? $post_result['data']['status'] : 0,
                'verify_desc'   => $post_result['msg']? $post_result['msg'] : '',
                'update_at'   => time(),
            ]);
            if ($result) {
                return ['status'=>1, 'desc'=>'添加成功', 'id' => $id];
            } else {
                return ['status'=>1, 'desc'=>'添加成功，同步失败', 'id' => $id];
            }
        }
        return  ['status'=>-1, 'desc'=>'提交失败'];
    }

    /**
     * 删除
     * @param int   $id  主健ID
     * @return array
     */
    public function del($id)
    {
        if($id <=0){
            return ['status'=>-1, 'desc'=>'参数错误'];
        }
        $model = new SmsSignData();
        $detail = $model->get(SmsSignData::SEARCH_BY_ID, $id);
        if(!$detail){
            return ['status'=>-2, 'desc'=>'数据不存在'];
        }

        $post_result = $this->model_sign->del($detail['sign_id']);
        //更新提交结果
        $model = new SmsSignData();
        $result = $model->update($id, [
            'is_hidden'       => $post_result['status'] == 0 ? 1 : 0,
            'verify_status'   => $post_result['status'],
            'verify_desc'     => $post_result['msg'],
            'update_at'   => time(),
        ]);
        if ($result) {
            return ['status'=>1, 'desc'=>'添加成功'];
        } elseif($post_result['status'] == 0) {
            return ['status'=>1, 'desc'=>'同步成功,更新失败'];
        } else {
            return ['status'=>-1, 'desc'=>'同步失败'];
        }
    }

    /**
     * 检查签名审核状态
     * @param $detail
     * @return array
     */
    public function check($detail)
    {
        $sign_id = $detail['sign_id'];
        $post_result = $this->model_sign->check($sign_id);
        //如果取返回值成功，则更新DB
        if(isset($post_result['status'])){
            //更新提交结果
            $model = new SmsSignData();
            $result = $model->update($detail['id'], [
                'verify_status'   => $post_result['status'],
                'verify_desc'     => $post_result['msg'],
                'update_at'     => time(),
            ]);
            if($result){
                return ['status'=>1, 'desc'=>'检查成功'];
            } else {
                return ['status'=>1, 'desc'=>'检查成功,保存本地失败'];
            }
        }

        return ['status'=>-1, 'desc'=>'检查失败'];
    }

}