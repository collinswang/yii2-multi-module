<?php
namespace frontend\controllers;


use common\modules\sms\service\SmsSignService;

class TestController extends BaseController
{
    public function actionIndex()
    {
        $model = new SmsSignService();
        $uid = 11;
        $sign = "测试";
        $desc = "这是一个测试";
        $result = $model->add($uid, $sign, $desc);
        print_r($result);
    }
}