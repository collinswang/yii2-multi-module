<?php

namespace common\modules\sms\base;

interface SmsSignInterface
{
    function add($sign, $desc);
    function update($sign_id,$sign, $desc);
    function del($sign_id);
    function check($sign_id);
}