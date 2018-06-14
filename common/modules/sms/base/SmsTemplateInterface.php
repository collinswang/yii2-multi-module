<?php
/**
 * 短信模板接口
 */
namespace common\modules\sms\base;

interface SmsTemplateInterface
{
    /**
     * 新增短信模板
     * @param string    $content    模板内家
     * @param int       $type       模板标签
     * @param string    $desc       模板说明
     * @param string    $title
     * @return mixed
     */
    function smsTemplateAdd($content, $type, $desc, $title);

    /**
     * 修改短信模板
     * @param int       $id         短信模板ID
     * @param int       $type       类型
     * @param string    $content    模板内家
     * @param string    $desc       模板说明
     * @param string    $title      模板标签
     * @return mixed
     */
    function smsTemplateUpdate($id, $content, $type, $desc, $title);

    /**
     * 删除短信模板
     * @param array   $id
     * @return mixed
     */
    function smsTemplateDel($id);

    /**
     * 检查短信模板
     * @param array   $id
     * @return mixed
     */
    function smsTemplateCheck($id);
}