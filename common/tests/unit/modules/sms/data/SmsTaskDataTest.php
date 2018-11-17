<?php
namespace common\tests\unit\modules\sms\data;

use common\modules\sms\data\SmsTaskData;
use common\modules\sms\data\SmsTemplateData;


/**
 * Login form test
 */
class SmsTaskDataTest extends \Codeception\Test\Unit
{
    const FILE = '/home/web/yii2-multi-module/frontend/sms_dir/2018_11_15/20181115164215_5bed3167e4d84.csv';
    const TEMPLATE_ID = 18;
    const TEST_UID = 1;

    public function testCheckTaskList()
    {
        $template_model = new SmsTemplateData();
        $template_info = $template_model->get(SmsTemplateData::SEARCH_BY_ID, self::TEMPLATE_ID);
        $file = '/home/web/yii2-multi-module/frontend/sms_dir/2018_11_15/20181115164215_5bed3167e4d84.csv';
        expect('判断是否为真，但传递过来的结果为正', $template_info['id']>0)->true();

        $model = new SmsTaskData();
        $result = $model->check_task_list($template_info, self::FILE);
        expect('判断是否为真，但传递过来的结果为正', count($result['list'])>0)->true();
        expect('判断是否为真，但传递过来的结果为正', $result['list'][0]['mobile']>0)->true();
        expect('判断是否为真，但传递过来的结果为正', strlen($result['list'][0]['content'])>5)->true();
    }

    public function testAdd()
    {
        $model = new SmsTaskData();
        $result = $model->add(self::TEST_UID,self::TEMPLATE_ID,self::FILE);
        expect('判断是否为真，但传递过来的结果为正', $result['id']>0)->true();
    }
}