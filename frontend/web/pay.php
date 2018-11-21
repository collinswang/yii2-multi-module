<?php
/**
 * 支付回调接口
 * @param   string  $code   支付类型： alipay:支付宝  wechat:微信支付 kuai:快钱支付
 * @param   string  $r      payment/feedback
 */
defined('YII_DEBUG') or define('YII_DEBUG', false);
defined('YII_ENV') or define('YII_ENV', 'prod');          // dev | prod

require(__DIR__ . '/../../vendor/autoload.php');
require(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../../common/config/bootstrap.php');
require(__DIR__ . '/../config/bootstrap.php');

$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../common/config/main.php'),
    require(__DIR__ . '/../../common/config/main-local.php'),
    require(__DIR__ . '/../config/main.php'),
    require(__DIR__ . '/../config/main-local.php')
);

$time1 = microtime(true);
//支付接口跳转到
$_GET['r'] = 'payment/feedback';
!isset($_GET['code']) && $_GET['code'] = $_POST['code'];
try{
    if($_GET['code']){
        file_put_contents(__DIR__.'/../runtime/logs/payment_'.date('Y-m-d').'.txt', json_encode(array($_POST,$_GET))."\r\n", FILE_APPEND);
    } else {
        $morexml = file_get_contents('php://input', 'r');
        file_put_contents(__DIR__.'/../runtime/logs/payment_'.date('Y-m-d').'.txt', json_encode([$morexml])."\r\n", FILE_APPEND);
    }
}catch (\Exception $e){}

$application = new yii\web\Application($config);
$application->run();
