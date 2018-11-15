<?php
namespace common\tests\unit\modules\sms\service;

use common\modules\sms\service\SmsSignService;
use Yii;

/**
 * Login form test
 */
class QcloudSmsSignServiceTest extends \Codeception\Test\Unit
{
    public function testAdd()
    {
        $model = new SmsSignService();
        $uid = 11;
        $sign = "测试";
        $desc = "这是一个测试";
        $result = $model->add($uid, $sign, $desc);
        expect('判断是否为真，但传递过来的结果为正', $result['id']? true : false)->true();
        $status = false;
        expect('结果为正', $status)->false();
    }
}