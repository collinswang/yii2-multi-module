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
        expect('判断是否为真，但传递过来的结果为正', $model->add('云提醒', '通过腾迅云进行多端提醒'))->true();
        $status = false;
        expect('结果为正', $status)->false();
    }
}