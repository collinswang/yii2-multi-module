<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-08-30 18:10
 */
namespace api\controllers;

class SiteController extends BaseController
{
    public $modelClass = "api\models\Article";
    

    public function actions()
    {
        return [];
    }

    public function verbs()
    {
        return [
            'index' => ['GET', 'HEAD'],
            'login' => ['POST'],
            'register' => ['POST'],
        ];
    }

    public function actionIndex()
    {
        return [
            "feehi api service"
        ];
    }

    public function actionLogin()
    {
        return [
            "username" => 'test',
            "sex" => "male",
        ];
    }

    public function actionRegister()
    {
        return [
            "success" => true
        ];
    }

}
