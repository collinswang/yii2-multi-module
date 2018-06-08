<?php
/**
 * 短信发送接口
 */
namespace common\modules\sms\base;

interface SmsInterface
{
    /**
     * 单次发送模板短信
     * @return mixed
     */
    function sms_send_template_msg_single($mobile, $tpl_id, $data);

    /**
     * 批量发送模板短信
     * @param array     $mobiles    手机号列表
     * @param int       $tpl_id     远程平台模板ID
     * @param array     $params     模板内对应参数表
     * @return mixed
     */
    function sms_send_template_msg_batch($mobiles, $tpl_id, $params);

    /**
     * 单次发送短信
     * @param $mobile
     * @param $params
     * @param $type
     * @return mixed
     */
    function sms_send_msg_single($mobile, $params, $type);

    /**
     * 批量发送短信
     * @param array     $mobiles    手机号列表
     * @param string    $content    短信内容
     * @param int       $type       短信类型，0 为普通短信，1 营销短信
     * @return mixed
     */
    function sms_send_msg_batch($mobiles, $content, $type);

    /**
     * 短信发送结果回调(队列)
     * @param $type
     * @param $max
     * @return mixed
     */
    function sms_send_callback($type, $max);

    /**
     * 获取指定手机短信回复
     * @param string        $mobile         手机号
     * @param int           $start_time     开始时间,UNIX时间戳
     * @param int           $end_time       结束时间,UNIX时间戳
     * @param int           $max            获取最大条数,最大100
     * @return mixed
     */
    function sms_reply_msg($mobile, $start_time, $end_time, $max);

    /**
     * 短信发送结果
     * @param string        $mobile         手机号
     * @param int           $start_time     开始时间,UNIX时间戳
     * @param int           $end_time       结束时间,UNIX时间戳
     * @param int           $max            获取最大条数,最大100
     * @return mixed
     */
    function sms_send_status($mobile, $start_time, $end_time, $max);
}