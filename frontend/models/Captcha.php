<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-03-15 21:16
 */

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class Captcha extends Model
{
    public $mobile;

    public $captcha;

    private $_user;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['mobile', 'required'],
            ['mobile', 'integer'],
            ['mobile','match','pattern'=>'/^1[0-9]{10}$/', 'message'=>'{attribute}必须为1开头的11位纯数字'],
            ['mobile', 'string', 'min'=>11,'max' => 11],
            [
                'captcha',
                'captcha',
                'captchaAction' => 'site/captcha',
                'message' => yii::t('app', 'Verification code error.')
            ],
        ];
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }

    const EXPIRE_TIME = 600;

    public function sendSms()
    {
        $code = rand(100000, 999999);
        Yii::$app->redis->executeCommand("setex", [$this->mobile, self::EXPIRE_TIME, $code]);
    }
}
