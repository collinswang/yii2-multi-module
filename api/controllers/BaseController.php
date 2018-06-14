<?php
namespace api\controllers;

use common\models\User;
use Yii;
use yii\web\Controller;
class BaseController extends Controller
{
    public $uid = 0;
    public $token = null;

    /**
     * 对所有访问请求鉴权
     */
    public function init()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $action = Yii::$app->requestedAction;
        $url = $action->controller->id;
        //根据header头传入的token鉴权
        $this->token = Yii::$app->request->headers['token'];
        $this->uid = Yii::$app->request->get()['uid'];
        if(!in_array($url, ["site"])){
            $check_token = $this->checkToken();
            if(!$check_token){
                echo json_encode(['status'=>-1, 'desc'=>'fail token', 'uid'=>$this->uid,'token'=>$this->token]);
                exit;
            }
        }
        parent::init();
    }

    /**
     * 生成TOKEN
     * @return string
     */
    public function buildToken()
    {
        $user = yii::$app->user->identity;
        $token = md5($user->id.$user->updated_at);
        return $token;
    }

    /**
     * 检查TOKEN
     * @return int
     */
    public function checkToken()
    {
        if (!$this->uid) {
            return false;
        }
        $user = User::findOne(['id'=>$this->uid]);
        if($user){
            $verify_token = md5($this->uid.$user->updated_at);
            if($verify_token == $this->token){
                return true;
            }
        }
        return false;
    }
}