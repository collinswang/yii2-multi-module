<?php
namespace common\tests\unit\modules\sms\service;

use common\modules\sms\service\QcloudSmsSignService;
use Yii;

/**
 * Login form test
 */
class QcloudSmsSignServiceTest extends \Codeception\Test\Unit
{
    public function testAdd()
    {
        $model = new QcloudSmsSignService();
        print_r($model->add());
        $status = true;
        expect('判断是否为假，但传递过来的结果为正', $status)->false();
        $status = false;
        expect('结果为正', $status)->false();
    }
}