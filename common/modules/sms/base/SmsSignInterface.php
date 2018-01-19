<?php

namespace common\modules\sms\base;

interface SmsSignInterface
{
    function add($sign, $desc);
    function update();
    function del();
    function check();
}