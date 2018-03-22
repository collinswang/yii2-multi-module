<?php
namespace frontend\controllers;


use common\modules\sms\data\SmsSignData;
use common\modules\sms\service\SmsSignService;

class TestController extends BaseController
{
    public function actionIndex()
    {
        $new = new SmsSignService();
        $result = $new->add(11, '签名', '测试签名');
        print_r($result);
        $id = 3;
        $post_result['data']['id'] = 1;
        $post_result['data']['status'] = -8;
        $post_result['msg'] = 'no priv';
        $model = new SmsSignData();
        $result = $model->update($id, [
            'sign_id'       => $post_result['data']['id'] ? $post_result['data']['id'] : 0,
            'verify_status' => $post_result['data']['status'],
            'verify_desc'   => $post_result['msg'],
            'update_at'   => time(),
        ]);
        print_r($result);
    }
}