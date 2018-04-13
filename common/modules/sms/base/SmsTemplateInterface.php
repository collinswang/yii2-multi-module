<?php
/**
 * 短信模板接口
 */
namespace common\modules\sms\base;

interface SmsTemplateInterface
{
    function sms_template_add($sign, $desc);
    function sms_template_update($sign_id,$sign, $desc);
    function sms_template_del($sign_id);
    function sms_template_check($sign_id);
}