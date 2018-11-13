<?php
/**
 * 首页
 */

namespace frontend\controllers;


class IndexController extends BaseController
{
    //不用LAYOUT
    public $layout = false;

    //单页    ?r=index/page&view=about
    public function actions()
    {
        return [
            'page' => [
                'class' => 'yii\web\ViewAction',
                'viewPrefix' => '/pages',
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('/pages/index');
    }

}