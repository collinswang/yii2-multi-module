<?php

namespace common\modules\sms\base;

interface SmsSignInterface
{
    function add();
    function update();
    function del();
    function check();
}