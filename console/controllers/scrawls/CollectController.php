<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-05-18 11:13
 */
namespace console\controllers;


use yii;
use yii\console\Controller;


class CollectController extends Controller
{
    public $title = null;
    public $content = null;
    public $img = null;

    const START_URL = "https://www.aicoin.net.cn/currencies";

    public function actionIndex()
    {

    }

}
