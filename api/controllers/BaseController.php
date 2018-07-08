<?php
namespace api\controllers;

use common\models\User;
use Yii;
use yii\web\Controller;
class BaseController extends Controller
{
    public $uid = 0;
    public $token = null;
    public $layout = false;

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
        //根据header头传入的token鉴权
        $this->token = Yii::$app->request->headers['token'];
        $this->uid = isset($_GET['uid']) ? $_GET['uid'] : 0;
        if(!in_array($controller, ["site", "user"])){
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

//    /**
//     * 检查TOKEN
//     * @return int
//     */
//    public function checkToken()
//    {
//        if (!$this->uid) {
//            return false;
//        }
//        $user = User::findOne(['id'=>$this->uid]);
//        if($user){
//            $verify_token = md5($this->uid.$user->updated_at);
//            if($verify_token == $this->token){
//                return true;
//            }
//        }
//        echo "===$verify_token===";
//        return false;
//    }

    public function checkToken()
    {
        $mobile=$_POST['mobile'];
        $token=strtolower($_POST['token']);
        $mac_address=trim($_POST['mac']);
        $disk_id=trim($_POST['did']);;
        $border_id=trim($_POST['bid']);

        $new_token = md5($mobile.$mac_address.$disk_id.$border_id);
        if($token == $new_token){
            return true;
        }else{
            return false;
        }
    }
}