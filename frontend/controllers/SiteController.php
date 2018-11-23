<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-03-15 21:16
 */

namespace frontend\controllers;

use frontend\models\Captcha;
use Yii;
use common\models\LoginForm;
use frontend\models\form\PasswordResetRequestForm;
use frontend\models\form\ResetPasswordForm;
use frontend\models\form\SignupForm;
use yii\base\InvalidParamException;
use yii\captcha\CaptchaAction;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\HttpException;

/**
 * Site controller
 */
class SiteController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post', 'get'],
                ],
            ],
        ];
    }

    public function actions()
    {
        $captcha = [
            'class' => CaptchaAction::className(),
            'backColor' => 0x66b3ff,//背景颜色
            'maxLength' => 4,//最大显示个数
            'minLength' => 4,//最少显示个数
            'padding' => 1,//验证码字体大小，数值越小字体越大
            'height' => 34,//高度
            'width' => 100,//宽度
            'foreColor' => 0xffffff,//字体颜色
            'offset' => 13,//设置字符偏移量
        ];
        if( YII_ENV_TEST ) $captcha = array_merge($captcha, ['fixedVerifyCode'=>'testme']);
        return [
            'captcha' => $captcha,
        ];
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (! Yii::$app->getUser()->getIsGuest()) {
            //return $this->goHome();
            return Yii::$app->getResponse()->redirect(Yii::$app->getHomeUrl());
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->login()) {
            return $this->goBack();
        } else {
            yii::$app->getUser()->setReturnUrl(yii::$app->getRequest()->getHeaders()->get('referer'));
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public static $builtInValidators = [
        'boolean'  => 'yii\validators\BooleanValidator',
        'captcha'  => 'yii\captcha\CaptchaValidator',
        'compare'  => 'yii\validators\CompareValidator',
        'date'     => 'yii\validators\DateValidator',
        'datetime' => [
            'class' => 'yii\validators\DateValidator',
            'type'  => \yii\validators\DateValidator::TYPE_DATETIME,
        ],
        'time'     => [
            'class' => 'yii\validators\DateValidator',
            'type'  => \yii\validators\DateValidator::TYPE_TIME,
        ],
        'default'  => 'yii\validators\DefaultValueValidator',
        'double'   => 'yii\validators\NumberValidator',
        'each'     => 'yii\validators\EachValidator',
        'email'    => 'yii\validators\EmailValidator',
        'exist'    => 'yii\validators\ExistValidator',
        'file'     => 'yii\validators\FileValidator',
        'filter'   => 'yii\validators\FilterValidator',
        'image'    => 'yii\validators\ImageValidator',
        'in'       => 'yii\validators\RangeValidator',
        'integer'  => [
            'class'       => 'yii\validators\NumberValidator',
            'integerOnly' => true,
        ],
        'match'    => 'yii\validators\RegularExpressionValidator',
        'number'   => 'yii\validators\NumberValidator',
        'required' => 'yii\validators\RequiredValidator',
        'safe'     => 'yii\validators\SafeValidator',
        'string'   => 'yii\validators\StringValidator',
        'trim'     => [
            'class'       => 'yii\validators\FilterValidator',
            'filter'      => 'trim',
            'skipOnArray' => true,
        ],
        'unique'   => 'yii\validators\UniqueValidator',
        'url'      => 'yii\validators\UrlValidator',
        'ip'       => 'yii\validators\IpValidator',
    ];

    /**
     * 注册新用户
     *
     * @return mixed
     */
    public function actionReg()
    {
        if (!Yii::$app->getUser()->getIsGuest()) {
            return Yii::$app->getResponse()->redirect(['/user/index']);
        }

        $model = new SignupForm();
        $model->setScenario('create');
        if ($model->load(Yii::$app->getRequest()->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('reg', [
            'model' => $model,
        ]);
    }

    /**
     * 发送手机验证码
     *
     * @return mixed
     */
    public function actionSendCode()
    {
        Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
        if (!Yii::$app->getUser()->getIsGuest()) {
            return Yii::$app->getResponse()->redirect(['/user/index']);
        }

        $model = new SignupForm();
        if(Yii::$app->getRequest()->post('source', 0) == 2){
            $model->setScenario('sms_reset');
        } else {
            $model->setScenario('sms');
        }
        $model->load(Yii::$app->getRequest()->post());
        if ($model->validate()) {
            if($code = $model->sendSms()){
                return ['status'=>0, 'msg'=>'ok'.$code];
            } else {
                return ['status'=>-1, 'msg'=>'code send fail'];
            }

        } else {
            $errors = $model->errors;
            return ['status'=>-1, 'msg'=>$errors];
        }
    }

    /**
     * 注册新用户
     *
     * @return mixed
     */
    public function actionReset()
    {
        if (!Yii::$app->getUser()->getIsGuest()) {
            return Yii::$app->getResponse()->redirect(['/user/index']);
        }

        $model = new SignupForm();
        $model->setScenario('reset');
        if ($model->load(Yii::$app->getRequest()->post())) {
            if($model->resetPassword()){
                return Yii::$app->getResponse()->redirect(['/site/login']);
            }
        }

        return $this->render('reset', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->getUser()->logout(false);

        return $this->goHome();
    }

//    /**
//     * Signs user up.
//     *
//     * @return mixed
//     */
//    public function actionSignup()
//    {
//        $model = new SignupForm();
//        if ($model->load(Yii::$app->getRequest()->post())) {
//            if ($user = $model->signup()) {
//                if (Yii::$app->getUser()->login($user)) {
//                    return $this->goHome();
//                }
//            }
//        }
//
//        return $this->render('signup', [
//            'model' => $model,
//        ]);
//    }
//
//    /**
//     * Requests password reset.
//     *
//     * @return mixed
//     */
//    public function actionRequestPasswordReset()
//    {
//        $model = new PasswordResetRequestForm();
//        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
//            if ($model->sendEmail()) {
//                Yii::$app->getSession()
//                    ->setFlash('success', yii::t('app', 'Check your email for further instructions.'));
//
//                return $this->goHome();
//            } else {
//                Yii::$app->getSession()
//                    ->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
//            }
//        }
//
//        return $this->render('requestPasswordResetToken', [
//            'model' => $model,
//        ]);
//    }
//
//    /**
//     * Resets password.
//     *
//     * @param string $token
//     * @return mixed
//     * @throws BadRequestHttpException
//     */
//    public function actionResetPassword($token)
//    {
//        try {
//            $model = new ResetPasswordForm($token);
//        } catch (InvalidParamException $e) {
//            throw new BadRequestHttpException($e->getMessage());
//        }
//
//        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate() && $model->resetPassword()) {
//            Yii::$app->getSession()->setFlash('success', yii::t('app', 'New password was saved.'));
//
//            return $this->goHome();
//        }
//
//        return $this->render('resetPassword', [
//            'model' => $model,
//        ]);
//    }

    /**
     * 网站进入维护模式时
     * 即在后台网站设置中关闭了网站执行此操作
     *
     */
    public function actionOffline()
    {
        Yii::$app->getResponse()->statusCode = 503;
        yii::$app->getResponse()->content = "sorry, the site is temporary unserviceable";
        yii::$app->getResponse()->send();
    }


    /**
     * 切换网站视图
     * 请开发其他网站视图模版，并参照yii2文档配置
     *
     */
    public function actionView()
    {
        $view = Yii::$app->getRequest()->get('type');
        if (isset($view)) {
            Yii::$app->session['view'] = $view;
        }
        $this->goBack( Yii::$app->getRequest()->getHeaders()->get('referer') );
    }

    /**
     * 切换语言版本
     *
     */
    public function actionLanguage()
    {
        $language = Yii::$app->getRequest()->get('lang');
        if (isset($language)) {
            Yii::$app->session['language'] = $language;
        }
        $this->redirect( Yii::$app->getRequest()->getHeaders()->get('referer') );
    }

    /**
     * http异常捕捉后处理
     *
     * @return string
     */
    public function actionError()
    {
        $this->layout = false;
        if (($exception = Yii::$app->getErrorHandler()->exception) === null) {
            // action has been invoked not from error handler, but by direct route, so we display '404 Not Found'
            $exception = new HttpException(404, Yii::t('yii', 'Page not found.'));
        }

        if ($exception instanceof HttpException) {
            $code = $exception->statusCode;
        } else {
            $code = $exception->getCode();
        }
        //if ($exception instanceof Exception) {
        $name = $exception->getName();
        //} else {
        //$name = $this->defaultName ?: Yii::t('yii', 'Error');
        //}
        if ($code) {
            $name .= " (#$code)";
        }

        //if ($exception instanceof UserException) {
        $message = $exception->getMessage();
        //} else {
        //$message = $this->defaultMessage ?: Yii::t('yii', 'An internal server error occurred.');
        //}
        $statusCode = $exception->statusCode ? $exception->statusCode : 500;
        if (Yii::$app->getRequest()->getIsAjax()) {
            return "$name: $message";
        } else {
            return $this->render('error', [
                'code' => $statusCode,
                'name' => $name,
                'message' => $message,
                'exception' => $exception,
            ]);
        }
    }

    public function actionTest()
    {
        $model = new SignupForm();
        $model->setScenario('sms');
        $model->username = 13712223144;
        $result = $model->sendSms();
        print_r($result);
    }

}
