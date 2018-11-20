<?php
/**
 * 短信发送类
 * User: cf8
 * Date: 18-3-22
 * Time: 上午11:12
 */

namespace console\controllers;


use common\modules\sms\base\AliSmsClient;
use common\modules\sms\base\SmsInterface;
use common\modules\sms\data\SmsData;
use common\modules\sms\data\SmsTaskData;
use \common\modules\sms\models\SmsSign;
use common\modules\sms\service\SmsService;
use common\modules\sms\service\SmsSignService;
use Yii;

class SmsTaskController extends \yii\console\Controller
{

    const SLEEP_TIME = 5;
    /**
     * 异步任务入库并写入推送队列
     * php yii sms-task/queue
     */
    public function actionQueue()
    {
        $model = new SmsTaskData();
        while(true){
            $task_id = $model->getTaskQueue();
            if($task_id){
                $result = $model->processTaskQueue($task_id);
                echo "$task_id run success";
            } else {
                sleep(self::SLEEP_TIME);
                echo "Zzzz..\r\n";
            }
        }
    }

}