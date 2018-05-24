<?php
/**
 * SMS签名业务层逻辑
 */
namespace common\modules\sms\service;

use common\modules\sms\base\SmsInterface;
use common\modules\sms\data\SmsData;
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
     * @param int   $tpl_id
     * @param int   $mobile
     * @param array $params
     * @return array
     */
    public function send_template_single($uid, $tpl_id, $mobile, $params)
    {
        if (!$uid || !$tpl_id || !$mobile || !$params) {
            return ['status'=>-1, 'desc'=>'UID不能为空'];
        }

        //获取消息模板
        $build_result = $this->build_content($uid, $tpl_id, $params);
        if($build_result['status'] <=0){
            return ['status'=>$build_result['status'], 'desc'=>$build_result['desc']];
        }
        $content = $build_result['content'];
        $type = $build_result['type'];

        //添加本地签名记录
        $model = new SmsData();
        $id = $model->add(['uid'=>$uid, 'type'=>$type, 'template_id'=>$tpl_id, 'mobile'=>$mobile, 'content'=>$content, 'create_at'=>time()]);
        if($id){
            //调用API接口提交数据
            //发送方法一：发送模板ID及对应参数
            //$post_result = $this->model_sign->sms_send_template_msg_single($tpl_id, $params, $mobile);
            //发送方法二:发送生成好的短信
            $post_result = $this->model_sign->sms_send_msg_single($mobile, $content, $type);

            //更新本地签名记录，保存API接口返回结果
            if($post_result){
                $result = $model->update($id, [
                    'send_status' => isset($post_result['result']) ? $post_result['result'] : 0,
                    'send_desc' => isset($post_result['errmsg']) ? $post_result['errmsg'] : 0,
                    'sid'   => isset($post_result['sid']) ? $post_result['sid'] : 0,
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
     * @param int   $tpl_id
     * @param int|array   $mobile
     * @param array $params
     * @return array
     */
    public function send_template_batch($uid, $tpl_id, $mobile, $params)
    {
        if (!$uid || !$tpl_id || !$mobile || !$params) {
            return ['status'=>-1, 'desc'=>'UID不能为空'];
        }

        //获取消息模板
        $build_result = $this->build_content($uid, $tpl_id, $params);
        if($build_result['status'] <=0){
            return ['status'=>$build_result['status'], 'desc'=>$build_result['desc']];
        }
        $content = $build_result['content'];
        $type = $build_result['type'];

        $model = new SmsData();
        $ids = [];
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
            //发送方法二:发送生成好的短信
            $post_result = $this->model_sign->sms_send_msg_batch($mobile, $content, $type);
            if($post_result){
                if($post_result['result'] <> 0){
                    return ['status'=>-2, 'desc'=>$post_result['errmsg']];
                }
                $time = time();
                if(isset($post_result['detail'])){
                    foreach ($post_result['detail'] as $item) {
                        //更新本地签名记录，保存API接口返回结果
                        $model->update($ids[$item['mobile']], [
                            'send_status' => isset($post_result['result']) ? $post_result['result'] : 0,
                            'send_desc' => isset($post_result['errmsg']) ? $post_result['errmsg'] : 0,
                            'sid'   => isset($post_result['sid']) ? $post_result['sid'] : 0,
                            'update_at'   => $time,
                        ]);
                    }
                }
                return ['status'=>1, 'desc'=>'发送成功'];
            } else {
                return ['status'=>-3, 'desc'=>'同步发送失败'];
            }
        }
        return ['status'=>-1, 'desc'=>'添加失败'];
    }

    /**
     * 模板模板，自动生成短信内容
     * @param $uid
     * @param $tpl_id
     * @param $params
     * @return mixed
     */
    protected function build_content($uid, $tpl_id, $params)
    {
        $sms_temp_model = new SmsTemplateData();
        $template = $sms_temp_model->get(SmsTemplateData::SEARCH_BY_ID, intval($tpl_id));
        $temp_content = $template['content'];
        preg_match_all("/\{\d\}/", $temp_content, $temp_keys);
        //生成发送内容
        $content = str_replace( $temp_keys[0], $params, $temp_content);
        return ['status'=>1,'desc'=>"",'content'=>$content, 'type'=>$template['type']];
    }

    /**
     * 以队列形式获取短信发送结果
     * @param $type
     * @param $max
     * @return mixed
     */
    public function pull_status($type, $max)
    {
        $result = $this->model_sign->sms_send_callback($type, $max);
        //更新状态
        if($result['data']){
            $time = time();
            $model = new SmsData();
            foreach ($result['data'] as $item) {
                $model->update_status($item['sid'], [
                    'send_status' => $item['report_status'] == "SUCCESS" ? 0 : 1,
                    'send_desc' => isset($item['errmsg']) ? $item['errmsg'] : "",
                    'update_at'   => $time,
                ]);
            }
        }
        return $result;
    }

}