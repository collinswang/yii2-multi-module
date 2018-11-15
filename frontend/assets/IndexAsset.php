<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-08-12 22:37
 */

namespace frontend\assets;


use Yii;

class IndexAsset extends \yii\web\AssetBundle
{
//    public function init()
//    {
//        parent::init();
//        if( yii::$app->getRequest()->getBaseUrl() !== "" ){
//            $this->sourcePath = '@frontend/web';
//        }
//    }

    public $css = [
        'static/css/bootstrap.min.css',
        'static/css/font-awesome.min93e3.css',
    ];

    public $js = [
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
    ];
}