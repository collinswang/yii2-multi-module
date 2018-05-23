<?php
/**
 * SMS签名业务层逻辑
 */
namespace common\modules\sms\service;

use common\modules\sms\base\SmsInterface;
use common\modules\sms\data\SmsData;
use common\modules\sms\data\SmsSignData;
use common\modules\sms\data\SmsTemplateData;

class SmsService
{
    const SMS_SIGN_API_QCLOUD = 1;
    const SMS_SIGN_API_ALIDAYU = 2;
    protected static $sms_sign_api = [
        1 => 'common\modules\sms\base\QcloudSmsClient',
        2 => 'common\modules\sms\base\AliDayuSmsClient',
    ];

    public static function get_sms_api()
    {
        return self::$sms_sign_api;
    }

    protected $model_sign = '';

    public function __construct($model_sign)
    {
        if(!$model_sign instanceof SmsInterface){
            return ['status'=>-1, 'desc'=>'传入非SmsInterface的实例'];
        } else {
            $this->model_sign = $model_sign;
        }

        return true;
    }

    /**
     * 发送单条模板短信
     * @param int   $uid 用户UID
     * @param int   $type
     * @param int   $tpl_id
     * @param int   $mobile
     * @param array $params
     * @return array
     */
    public function send_template_single($uid, $type, $tpl_id, $mobile, $params)
    {
        if (!$uid || !$type || !$tpl_id || !$mobile || !$params) {
            return ['status'=>-1, 'desc'=>'UID不能为空'];
        }
        if (empty($sign)) {
            return ['status'=>-2, 'desc'=>'签名不能为空'];
        }
        //获取消息模板
        $sms_temp_model = new SmsTemplateData();
        $template = $sms_temp_model->get(SmsTemplateData::SEARCH_BY_ID, intval($tpl_id));
        //生成发送内容
        $content = str_replace( array_keys($params), $params, $template);
        //发送

        //添加本地签名记录
        $model = new SmsData();
        $id = $model->add(['uid'=>$uid, 'type'=>$type, 'template_id'=>$tpl_id, 'mobile'=>$mobile, 'content'=>$content, 'create_at'=>time()]);
        if($id){
            //调用API接口提交数据
            $post_result = $this->model_sign->sms_send_template_msg_single($tpl_id, $params, $mobile);
            //更新本地签名记录，保存API接口返回结果
            if($post_result){
                $result = $model->update($id, [
                    'send_status' => $post_result['result'] ? $post_result['result'] : 0,
                    'send_desc' => $post_result['errmsg'] ? $post_result['errmsg'] : 0,
                    'sid'   => $post_result['sid'],
                    'update_at'   => time(),
                ]);
                if($result){
                    return ['status'=>1, 'desc'=>'添加成功', 'id' => $id];
                } else {
                    return ['status'=>1, 'desc'=>'更新失败', 'id' => $id];
                }
            } else {
                return ['status'=>1, 'desc'=>'同步发送失败', 'id' => $id];
            }
        }
        return ['status'=>-1, 'desc'=>'添加失败'];
    }

    /**
     * 发送多条模板短信
     * @param int   $uid 用户UID
     * @param int   $type
     * @param int   $tpl_id
     * @param int|array   $mobile
     * @param array $params
     * @return array
     */
    public function send_template_batch($uid, $type, $tpl_id, $mobile, $params)
    {
        if (!$uid || !$type || !$tpl_id || !$mobile || !$params) {
            return ['status'=>-1, 'desc'=>'UID不能为空'];
        }
        if (empty($sign)) {
            return ['status'=>-2, 'desc'=>'签名不能为空'];
        }
        //获取消息模板
        $sms_temp_model = new SmsTemplateData();
        $template = $sms_temp_model->get(SmsTemplateData::SEARCH_BY_ID, intval($tpl_id));
        //生成发送内容
        $content = str_replace( array_keys($params), $params, $template);

        $model = new SmsData();
        $ids = 0;
        $time = time();
        if(is_array($mobile)){
            foreach ($mobile as $item) {
                $ids[$item] = $model->add(['uid'=>$uid, 'type'=>$type, 'template_id'=>$tpl_id, 'mobile'=>$item, 'content'=>$content, 'create_at'=>$time]);
            }
        } else {
            $ids[$mobile] = $model->add(['uid'=>$uid, 'type'=>$type, 'template_id'=>$tpl_id, 'mobile'=>$mobile, 'content'=>$content, 'create_at'=>$time]);
        }
        //添加本地签名记录
        if($ids){
            //调用API接口提交数据
            $post_result = $this->model_sign->sms_send_template_msg_batch($mobile, $tpl_id, $params);
            if($post_result){
                $time = time();
                if($post_result['detail']){
                    foreach ($post_result['detail'] as $item) {
                        //更新本地签名记录，保存API接口返回结果
                        $model->update($ids[$item['mobile']], [
                            'send_status' => $item['result'] ? $item['result'] : 0,
                            'send_desc' => $item['errmsg'] ? $item['errmsg'] : 0,
                            'sid'   => $item['sid'],
                            'update_at'   => $time,
                        ]);
                    }
                }
                return ['status'=>1, 'desc'=>'发送成功'];
            } else {
                return ['status'=>1, 'desc'=>'同步发送失败'];
            }
        }
        return ['status'=>-1, 'desc'=>'添加失败'];
    }

     /**
     * 检查签名审核状态
     * @param $detail
     * @return array
     */
    public function check($detail)
    {
        $sign_id = $detail['sign_id'];
        $post_result = $this->model_sign->sms_sign_check([$sign_id]);
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