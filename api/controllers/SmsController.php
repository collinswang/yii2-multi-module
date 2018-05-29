<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-03-15 21:16
 */

namespace api\controllers;


/**
 * Sms controller
 */
class SmsController extends BaseController
{
    public function actionIndex()
    {
        return ['status'=>1, 'desc'=>"11111", 'uid'=>$this->uid];
    }

    /**
     * 发送记录
     * @return array
     */
    public function actionSend()
    {
        $file = $_FILES['list'];
        $content = file_get_contents($file['tmp_name']);
        $content = str_replace(["\r\n", "\r"], "\n", $content);
        $content = explode("\n", $content);
        if($content){
            foreach ($content as $item) {
                if(!$item){continue;}
                $item_arr = explode(",", $item);
                //入库并执行短信发送队列

            }
        }
        exit;
        return ['status'=>1, 'desc'=>"11111", 'uid'=>$this->uid];
    }

}
