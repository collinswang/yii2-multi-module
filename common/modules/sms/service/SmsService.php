<?php
/**
 * SMS签名业务层逻辑
 */
namespace common\modules\sms\service;

use common\modules\sms\base\SmsInterface;
use common\modules\sms\data\SmsData;
use common\modules\sms\data\SmsTemplateData;
use common\modules\sms\models\Sms;
use yii\base\BaseObject;

class SmsService extends BaseObject
{
    const SMS_SIGN_API_QCLOUD = 1;
    const SMS_SIGN_API_ALIDAYU = 2;
    public static $sms_sign_api = [
        1 => 'common\modules\sms\base\QcloudSmsClient',
        2 => 'common\modules\sms\base\AliSmsClient',
    ];

    public static function getSmsApi()
    {
        return self::$sms_sign_api;
    }

    protected $model_sign = '';

    public function __construct($sms_api_id)
    {
        $model_sign = new self::$sms_sign_api[$sms_api_id];
        if(!$model_sign instanceof SmsInterface){
            return ['status'=>-1, 'desc'=>'传入非SmsInterface的实例'];
        } else {
            $this->model_sign = $model_sign;
        }
        parent::__construct();
        return true;
    }

    /**
     * 发送单条模板短信
     * @param int   $uid 用户UID
     * @param array   $tpl_detail       模板详情
     * @param string   $mobile
     * @param array $params
     * @return array
     */
    public function sendTemplateSingle($uid, $tpl_detail, $mobile, $params)
    {
        if (!$uid || !$tpl_detail || !$mobile || !$params) {
            return ['status' => -1, 'desc' => 'UID不能为空'];
        }

        $mobile = intval(str_replace('"', '', $mobile));

        //获取消息模板
        $build_result = $this->buildContent($tpl_detail, $params);
        if ($build_result['status'] <= 0) {
            return ['status' => $build_result['status'], 'desc' => $build_result['desc']];
        }
        //数组转STRING，这是为了方便异步发送短信
        $content = json_encode($build_result['content']);
        $type = $build_result['type'];

        //添加本地签名记录
        $model = new SmsData();
        $id = $model->add(['uid'         => $uid,
                           'type'        => $type,
                           'template_id' => $tpl_detail['template_id'],
                           'mobile'      => $mobile,
                           'content'     => $content,
                           'create_at'   => time(),
        ]);
        if ($id) {
            return ['status' => 1, 'desc' => '添加成功', 'id' => $id];
        }

        return ['status' => -1, 'desc' => '添加失败'];
    }


    /**
     * 异步短信发送队列
     * @return int
     */
    public function sendSmsSync()
    {
        try{
            $sms_model = new SmsData();
            $sms_detail = $sms_model->getQueue();
            if(!$sms_detail || !isset($sms_detail['content'])){
                return -1;
            }
            $params = json_decode($sms_detail['content'], true);
            $post_result = $this->sendSmsDirect($sms_detail['mobile'], $sms_detail['template_id'], $params);
            //更新本地签名记录，保存API接口返回结果
            if($post_result){
                //防止数据库链接超时
                $db_con = \Yii::$app->db;
                $db_con->open();
                $result = $sms_model->update($sms_detail['id'], [
                    'send_status' => isset($post_result['result']) ? $post_result['result'] : 0,
                    'send_desc' => isset($post_result['errmsg']) ? $post_result['errmsg'] : 0,
                    'sid'   => isset($post_result['sid']) ? $post_result['sid'] : 0,
                    'update_at'   => time(),
                ]);
                $db_con->close();
                if($result){
                    return $sms_detail['id'];
                } else {
                    return -2;
                }
            } else {
                return -3;
            }
        } catch (\Exception $e){
            print_r($e->getMessage());
            return -4;
        }
    }

    /**
     * 直接发送短信
     * @param $mobile
     * @param $template_id
     * @param $params
     * @return mixed
     * Array
     *     (
     *     [Message] => OK
     *     [RequestId] => 0C1FECA0-6B38-479D-BC11-14A346A48803
     *     [BizId] => 691912330085565202^0
     *     [Code] => OK
     *     )
     */
    public function sendSmsDirect($mobile, $template_id, $params)
    {
        $post_result = $this->model_sign->smsSendTemplateMsgSingle($mobile, $template_id, $params);
        return $post_result;
    }

    /**
     * 模板模板，自动生成短信内容
     * @param $template
     * @param $params
     * @return mixed
     */
    public static function buildContent($template, $params)
    {
        $result = [];
        $temp_content = $template['content'];
        preg_match_all('/\{(\w*)\}/', $temp_content, $temp_keys);
        $temp_keys = $temp_keys[1];
        $total_params = count($temp_keys);
        if($total_params > count($params)){
            return ['status'=>-1,'desc'=>"少参数", 'type'=>$template['type']];
        }

        if($temp_keys){
            foreach ($temp_keys as $key=>$item) {
                $result[$item] = $params[$key];
            }
        }

        return ['status'=>1,'desc'=>"",'content'=>$result, 'type'=>$template['type']];
    }

    /**
     * 以队列形式获取短信发送结果
     * @param $type
     * @param $max
     * @return mixed
     */
    public function pullStatus($type, $max)
    {
        $result = $this->model_sign->smsSendCallback($type, $max);
        //更新状态
        if($result['data']){
            $time = time();
            $model = new SmsData();
            foreach ($result['data'] as $item) {
                $model->updateStatus($item['sid'], [
                    'send_status' => $item['report_status'] == "SUCCESS" ? 0 : 1,
                    'send_desc' => isset($item['errmsg']) ? $item['errmsg'] : "",
                    'update_at'   => $time,
                ]);
            }
        }
        return $result;
    }

    /**
     * 按页查询短信发送记录
     * @param int  $uid
     * @param int  $page
     * @param int  $page_size
     * @param int  $start_time
     * @param int  $end_time
     * @param null $source
     * @param null $mobile
     * @param null $send_status
     * @return array
     */
    public function getSendList($uid, $page=1, $page_size=20, $start_time=0, $end_time=0, $source = null, $mobile = null, $send_status = null)
    {
        $model = new SmsData();
        $page = intval($page);
        $page_size = intval($page_size);
        $start_time = intval($start_time);
        $end_time = intval($end_time);
        $source = intval($source);
        $mobile = intval($mobile);
        $send_status = $send_status ? 0 : 1;
        $result = $model->getSmsSendList($uid, $page, $page_size, $start_time, $end_time,$source, $mobile, $send_status);
        return $result;
    }

}