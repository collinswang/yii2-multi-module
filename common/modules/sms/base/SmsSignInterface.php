<?php
/**
 * 短信签名接口
 */
namespace common\modules\sms\base;

interface SmsSignInterface
{
    /**
     * 增加签名
     * @param string    $sign   签名
     * @param string    $desc   说明
     * @return mixed
     */
    function smsSignAdd($sign, $desc);

    /**
     * 修改签名
     * @param int       $sign_id    目标平台签名ID
     * @param string    $sign       签名
     * @param string    $desc       说明
     * @return mixed
     */
    function smsSignUpdate($sign_id,$sign, $desc);

    /**
     * 删除签名
     * @param array       $sign_id    目标平台签名ID
     * @return mixed
     */
    function smsSignDel($sign_id);

    /**
     * 查询签名状态
     * @param array       $sign_id    目标平台签名ID
     * @return mixed
     */
    function smsSignCheck($sign_id);
}