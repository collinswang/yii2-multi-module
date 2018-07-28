<?php
namespace api\controllers;

use common\components\Tools;
use common\models\User;
use Yii;
use yii\web\Controller;
class BaseController extends Controller
{
    public $uid = 0;
    public $token = null;
    public $layout = false;
    public $hash_pwd = "OIWiidwo862!%6";

    /**
     * 对所有访问请求鉴权
     */
    public function init()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $r = $_GET['r'] ? $_GET['r'] : 'site/index';
        $r_arr = explode('/', $r);
        $controller = $r_arr[0];
        $action = $r_arr[1];
        $this->uid = isset($_REQUEST['uid']) ? intval($_REQUEST['uid']) : 0;;

        if(!in_array($controller, ["site"])){
            if($controller == "user"){
                $check_token = $this->checkVerifyToken();
            } else {
                $check_token = $this->checkToken();
            }
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
        $mobile=Tools::check_input($_POST['mobile']);
        $mac_address=Tools::check_input(trim($_POST['mac']));
        $disk_id=Tools::check_input(trim($_POST['did']));
        $border_id=Tools::check_input(trim($_POST['bid']));
        $user = yii::$app->user->identity;
        $token = md5($mobile.$mac_address.$disk_id.$border_id.$user->id.$user->updated_at);
        return $token;
    }

    /**
     * 检查TOKEN
     * @return int
     */
    public function checkToken()
    {
        $mobile=Tools::check_input($_GET['mobile']);
        $token=Tools::check_input(strtolower($_GET['token']));
        $mac_address=Tools::check_input(trim($_GET['mac']));
        $disk_id=Tools::check_input(trim($_GET['did']));
        $border_id=Tools::check_input(trim($_GET['bid']));
        if (!$this->uid) {
            return false;
        }
        $user = User::findOne(['id'=>$this->uid]);
        if($user){
            $verify_token = md5($mobile.$mac_address.$disk_id.$border_id.$user->id.$user->updated_at);
            if($verify_token == $token){
                return true;
            }
        }
        return false;
    }

    /**
     * 检查验证码发送接口TOKEN (token由APP端生成, dev由APP端创建)
     * @return bool
     */
    public function checkVerifyToken()
    {
        $token=strtolower($_REQUEST['token']);
        $mobile=$_REQUEST['mobile'];
        $dev=trim($_REQUEST['dev']);

        $new_token = md5($mobile.$dev);
        if($token == $new_token){
            return true;
        }else{
            return false;
        }
    }
}