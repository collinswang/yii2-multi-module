<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-03-15 21:16
 */

namespace frontend\controllers;

use frontend\models\form\SignupForm;
use frontend\models\User;
use Yii;
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

    /**
     * 修改管理员账号
     *
     * @return string|\yii\web\Response
     * @throws \Exception
     * @throws \Throwable
     */
    public function actionInfo()
    {
        $model = new SignupForm();
        $model->setScenario('self_update');

        if (Yii::$app->getRequest()->getIsPost()) {

            if ($model->load(Yii::$app->request->post()) && $model->selfUpdate()) {
                Yii::$app->getSession()->setFlash('success', yii::t('app', 'Success'));
            } else {
                $errors = $model->getErrors();
                $err = '';
                foreach ($errors as $v) {
                    $err .= $v[0] . '<br>';
                }
                Yii::$app->getSession()->setFlash('error', $err);
            }
        } else {
            $model->username = Yii::$app->getUser()->getIdentity()->username;
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

}
