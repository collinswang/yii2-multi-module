<?php
/**
 *
 * User: collins
 * Date: 18-11-20
 */

namespace common\events;


use yii\base\Event;

class SmsTaskEvent extends Event
{
    public $task_id;
}