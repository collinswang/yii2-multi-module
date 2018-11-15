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
use api\models\User;

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
     * 登录
     *
     * @return mixed
     */
    public function actionLogin()
    {
        $uid = $token = 0;
        $model = new LoginForm();
        $post = Yii::$app->getRequest()->post();
        //检查手机号
        $check_mobile = Tools::check_mobile($post["mobile"]);
        $check_verify = Tools::check_input($post["verify"]);
        if(!$check_mobile || !$check_verify){
            return  ['status'=>-1, 'desc'=>'参数错误', 'uid'=>$uid, 'token'=>$token];
        }

        //检查验证码
        if ($post['mobile'] && $post['verify']) {
            $model->username = $post['mobile'];
            $model->password = $post['verify'];
            if($model->login()){
                $uid = yii::$app->user->identity->getId();
                $token = self::buildToken();
                return ['status'=>1, 'desc'=>'登录成功', 'uid'=>$uid, 'token'=>$token];
            }
        }
        return ['status'=>-1, 'desc'=>'登录失败', 'uid'=>$uid, 'token'=>$token];
    }


    /**
     * 发送验证码
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $post = Yii::$app->getRequest()->post();
        if(!isset($post['mobile'])){
            return ['status'=>0, 'desc'=>'请填写手机号'];
        }

        $mobile = $post['mobile'];
        $email = $mobile."@test.com";
        $password = Tools::genVerifyCode();
        //发送验证码
        $sms_model = new SmsService(Yii::$app->params['smsPlatform']);
        $login_template = Yii::$app->params['smsRegTemplate'][Yii::$app->params['smsPlatform']];
        $params = ['code' => $password];
//        $single_result = $sms_model->sendSmsDirect($mobile, $login_template, $params);
        $single_result['Code'] = 'OK';
        if(strtoupper($single_result['Code']) == 'OK'){
            //检查用户是否存在
            $user = User::findByUsername($mobile);
            if($user){
                $user->generateAuthKey();
                $user->setPassword($password);
                if ($user->save()) {
                    return ['status'=>2, 'desc'=>'密码发送成功'.$password];
                }
            } else {
                $model = new User();
                $model->username = strval($mobile);
                $model->email = $email;
                $model->created_at = time();
                $model->generateAuthKey();
                $model->setPassword($password);
                $model->updated_at = 0;
                if ($model->save()) {
                    return ['status'=>1, 'desc'=>'密码发送成功'.$password];
                }
            }
        }
        return ['status'=>0, 'desc'=>'密码发送失败'];

    }

}
