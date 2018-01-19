<?php
namespace frontend\controllers;


use common\modules\sms\service\QcloudSmsSignService;

class TestController extends BaseController
{
    public function actionIndex()
    {
        $model = new QcloudSmsSignService();
        print_r($model->add('云提醒', '通过腾迅云进行多端提醒'));
    }
}