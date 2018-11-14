<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-03-15 21:16
 */
namespace frontend\models\form;

use yii;
use common\models\User;
use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{

    public $username;

    public $email;

    public $password;

    public $password_repeat;

    public $verify_code;

    public $captcha;

    const EXPIRE_TIME = 600;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            [
                'username',
                'unique',
                'targetClass' => User::className(),
                'message' => yii::t('frontend', 'This username has already been taken')
            ],
            ['username','match','pattern'=>'/^1[0-9]{10}$/','message'=>'{attribute}必须为1开头的11位数字'],

            ['captcha', 'required'],
            [
                'captcha',
                'captcha',
                'captchaAction' => 'site/captcha',
                'message' => yii::t('app', 'Verification code error.')
            ],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['password_repeat', 'required'],
            ['password_repeat', 'compare','compareAttribute' => 'password'],

            ['verify_code', 'required'],
            ['verify_code', 'string', 'min' => 6],
            ['verify_code', 'checkVerifyCode'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'create' => ['username', 'password', 'verify_code'],
            'sms' => ['username', 'captcha'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => yii::t('app', 'Username'),
            'email' => yii::t('app', 'Email'),
            'old_password' => yii::t('app', 'Old Password'),
            'password' => yii::t('frontend', 'Password'),
            'password_repeat' => yii::t('frontend', 'Repeat Password'),
            'avatar' => yii::t('app', 'Avatar'),
            'created_at' => yii::t('app', 'Created At'),
            'updated_at' => yii::t('app', 'Updated At'),
            'rememberMe' => yii::t('frontend', 'Remember Me'),
            'captcha' => yii::t('frontend', 'Captcha'),
            'verify_code' => yii::t('frontend', 'Verify Code'),
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (! $this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->username."@qq.com";
        $user->setPassword($this->password);
        $user->generateAuthKey();

        return $user->save() ? $user : null;
    }

    /**
     * 发送验证码
     */
    public function sendSms()
    {
        $code = rand(100000, 999999);
        Yii::$app->redis->executeCommand("setex", [$this->username, self::EXPIRE_TIME, $code]);
        return $code;
    }


    public function checkVerifyCode($attribute, $params)
    {
        $verify_code = Yii::$app->redis->executeCommand("GET", [$this->username]);
        if($this->verify_code == $verify_code){
            return true;
        } else {
            $this->addError($attribute, yii::t('frontend', 'Verify Code Error'));
            return false;
        }
    }
}
