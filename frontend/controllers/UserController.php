<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-03-15 21:16
 */

namespace frontend\controllers;

use yii\filters\AccessControl;

/**
 * User controller
 */
class UserController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    //首页
    public function actionIndex()
    {
        return $this->renderPartial('index');
    }

    public function actionMain()
    {
        return $this->render('main',[
            'info' => [],
            'status' => [],
            'statics' => [],
            'comments' => [],
        ]);
    }

}
