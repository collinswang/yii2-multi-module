<?php
/**
 * 签名异步更新脚本
 * User: cf8
 * Date: 18-3-22
 * Time: 上午11:12
 */

namespace console\controllers;


use \common\modules\sms\models\SmsSign;
use common\modules\sms\service\SmsSignService;

class SmsSignController extends \yii\console\Controller
{
    /**
     * 检查签名审核结果
     */
    public function actionCheck()
    {
        $page_size = 100;
        $sql = "verify_status = 1 and is_hidden=0";
        $sms_sign_api = SmsSignService::get_sms_sign_api();
        foreach (SmsSign::find()->where($sql)->asArray()->batch($page_size) as $list) {
            if($list){
                foreach ($list as $item) {
                    $model = new SmsSignService(new $sms_sign_api[$item['source']]);
                    $model->check($item);
                }
            }
        }

    }

    public function actionTest()
    {
        $result = [];
        $str = "1234567890";
        $len = 4;
        $count = strlen($str);
        for($i = 0; $i<$count; $i++){
            $single = $this->actionGetStr(substr($str, $i), $len);
            if($single){
                $result = array_merge($result, $single);
            }
        }
        print_r($result);
    }

    public function actionGetStr($str, $len, $header = '')
    {
        $result = [];
        if(strlen($str) >= $len){
            if($len > 2){
                $start = $str[0];
                $str = substr($str, 1);
                $result = $this->actionGetStr($str, $len-1, $header.$start);
            } else {
                $start = $str[0];
                $str = substr($str, 1);
                $len = strlen($str);
                for($i = 0; $i<$len; $i++){
                    $result[] = $header.$start.$str[$i];
                }
            }
        }

        return $result;
    }
}