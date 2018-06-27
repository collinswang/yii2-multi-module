<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-03-15 21:16
 */

namespace api\controllers;

use common\components\Tools;
use common\modules\sms\service\SmsService;
use Yii;
use common\models\LoginForm;
use common\models\User;

/**
 * Site controller
 */
class UserController extends BaseController
{


    public function actionIndex()
    {
        return ['status'=>1, 'desc'=>"ok"];
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return ['status'=>-1, 'desc'=>'登录失败'];
        }
    }


    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $post = Yii::$app->getRequest()->post();
        $mobile = $post['mobile'];
        $email = $mobile."@test.com";
        $password = Tools::genVerifyCode();

        //发送验证码
        $sms_model = new SmsService(Yii::$app->params['smsPlatform']);
        $login_template = Yii::$app->params['smsRegTemplate'][Yii::$app->params['smsPlatform']];
        $params = ['code' => $password];
        $single_result = $sms_model->sendSmsDirect($mobile, $login_template, $params);
        print_r($single_result);
        if(strtoupper($single_result['Code']) == 'OK'){
            //检查用户是否存在
            $user = User::findByUsername($mobile);
            print_r($user->attributes);
            if($user){
                echo "记录存在\r\n";
                $user->generateAuthKey();
                $user->setPassword($password);
                if ($user->save()) {
                    return ['status'=>2, 'desc'=>'密码发送成功'];
                }
            } else {
                echo "记录不存在\r\n";
                $model = new User();
                $model->username = $mobile;
                $model->email = $email;
                $model->created_at = time();
                $model->generateAuthKey();
                $model->setPassword($password);
                $model->updated_at = 0;
                if ($model->save()) {
                    return ['status'=>1, 'desc'=>'密码发送成功'];
                }
            }
        }
        return ['status'=>0, 'desc'=>'密码发送失败'];

    }

}
