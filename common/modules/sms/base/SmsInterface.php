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
    function sms_send_template_msg_single();

    /**
     * 批量发送模板短信
     * @return mixed
     */
    function sms_send_template_msg_batch();

    /**
     * 单次发送短信
     * @return mixed
     */
    function sms_send_msg_single();

    /**
     * 批量发送短信
     * @return mixed
     */
    function sms_send_msg_batch();

    /**
     * 短信发送结果回调
     * @return mixed
     */
    function sms_send_callback();

    /**
     * 获取短信回复
     * @return mixed
     */
    function sms_reply_msg();

    /**
     * 短信发送结果
     * @return mixed
     */
    function sms_send_status();
}