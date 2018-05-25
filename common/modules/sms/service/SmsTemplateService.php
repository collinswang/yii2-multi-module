<?php
/**
 * SMS签名业务层逻辑
 */
namespace common\modules\sms\service;

use common\modules\sms\base\SmsTemplateInterface;
use common\modules\sms\data\SmsSignData;
use common\modules\sms\data\SmsTemplateData;
use yii\base\BaseObject;

class SmsTemplateService extends BaseObject
{
    const SMS_SIGN_API_QCLOUD = 1;
    const SMS_SIGN_API_ALIDAYU = 2;
    protected static $sms_sign_api = [
        1 => 'common\modules\sms\base\QcloudSmsTemplateClient',
        2 => 'common\modules\sms\base\AliDayuSmsTemplateClient',
    ];

    public static function get_sms_sign_api()
    {
        return self::$sms_sign_api;
    }

    protected $model_sign = '';

    public function __construct($model_sign)
    {
        if(!$model_sign instanceof SmsTemplateInterface){
            return ['status'=>-1, 'desc'=>'传入非 SmsTemplateInterface 的实例'];
        } else {
            $this->model_sign = $model_sign;
        }

        return true;
    }

    /**
     * 新增模板
     * @param int    $uid     用户UID
     * @param string $content 模板内容签名
     * @param        $type
     * @param string $desc    签名说明
     * @param        $title
     * @return array
     */
    public function add($uid, $content, $type, $desc, $title)
    {
        if (!$uid) {
            return ['status'=>-1, 'desc'=>'UID不能为空'];
        }
        if (empty($content)) {
            return ['status'=>-2, 'desc'=>'模板内容不能为空'];
        }
        //添加本地签名记录
        $model = new SmsTemplateData();
        $id = $model->add(['uid'=>$uid, 'content'=>$content, 'title'=>$title, 'desc'=>$desc, 'source'=>1, 'template_id'=>0, 'create_at'=>time()]);
        if($id){
            //调用API接口提交数据
            $post_result = $this->model_sign->sms_template_add($content, $type, $desc, $title);
            if($post_result['data']['id']){
                //更新本地签名记录，保存API接口返回结果
                $result = $model->update($id, [
                    'template_id'       => $post_result['data']['id'] ? $post_result['data']['id'] : 0,
                    'verify_status' => $post_result['data']['status'] ? $post_result['data']['status'] : 0,
                    'verify_desc'   => $post_result['msg']? $post_result['msg'] : '',
                    'update_at'   => time(),
                ]);
            }
            if($post_result['data']['id'] && $result){
                return ['status'=>1, 'desc'=>'添加成功', 'id' => $id];
            } else {
                return ['status'=>1, 'desc'=>'添加成功，同步失败', 'id' => $id];
            }
        }
        return ['status'=>-1, 'desc'=>'添加失败'];
    }

    /**
     * 修改模板
     * @param int       $id
     * @param string    $content    模板内容
     * @param int       $type       模板类型 0:普通短信模板 1：营销短信模板
     * @param string    $desc       备注,方便审核
     * @param string    $title      别名,方便管理
     * @return array
     */
    public function update($uid, $id, $content, $type, $desc, $title)
    {
        //数据安全性检查
        $id = intval($id);
        $type = intval($type);
        if($id <= 0 || !$content){
            return  ['status'=>-1, 'desc'=>'模板内容不能为空'];
        }

        //存DB
        $model = new SmsTemplateData();

        $verify = $model->check($uid, $id);
        if(!$verify){
            return  ['status'=>-1, 'desc'=>'无权限修改此条记录'];
        }

        $total = $model->update($id, ['content'=>$content, 'title'=>$title, 'desc'=>$desc, 'update_at'=>time()]);
        //提交到指定平台
        if($total){
            $post_result = $this->model_sign->sms_template_update($id, $content, $type, $desc, $title);
            //更新提交结果
            $result = $model->update($id, [
                'template_id'       => $post_result['data']['id'] ? $post_result['data']['id'] : 0,
                'verify_status' => $post_result['data']['status'] ? $post_result['data']['status'] : 0,
                'verify_desc'   => $post_result['msg']? $post_result['msg'] : '',
                'update_at'   => time(),
            ]);
            if ($result) {
                return ['status'=>1, 'desc'=>'添加成功', 'id' => $id];
            } else {
                return ['status'=>1, 'desc'=>'添加成功，同步失败', 'id' => $id];
            }
        }
        return  ['status'=>-1, 'desc'=>'提交失败'];
    }

    /**
     * 删除
     * @param     $uid
     * @param int $id 主健ID
     * @return array
     */
    public function del($uid, $id)
    {
        if($id <=0){
            return ['status'=>-1, 'desc'=>'参数错误'];
        }
        $model = new SmsTemplateData();
        $detail = $model->get(SmsSignData::SEARCH_BY_ID, $id);
        if(!$detail || $detail['uid'] != $uid){
            return ['status'=>-2, 'desc'=>'数据不存在或无权限'];
        }
        //删除远端数据
        $post_result = $this->model_sign->sms_template_del([$detail['template_id']]);
        //更新提交结果
        $model = new SmsSignData();
        $result = $model->update($id, [
            'is_hidden'       => $post_result['status'] == 0 ? 1 : 0,
            'verify_status'   => $post_result['status'],
            'verify_desc'     => $post_result['msg'],
            'update_at'   => time(),
        ]);
        if ($result) {
            return ['status'=>1, 'desc'=>'添加成功'];
        } elseif($post_result['status'] == 0) {
            return ['status'=>1, 'desc'=>'同步成功,更新失败'];
        } else {
            return ['status'=>-1, 'desc'=>'同步失败'];
        }
    }

    /**
     * 检查签名审核状态
     * @param $id
     * @return array
     */
    public function check($id)
    {
        if($id <=0){
            return ['status'=>-1, 'desc'=>'参数错误'];
        }
        $model = new SmsTemplateData();
        $detail = $model->get(SmsTemplateData::SEARCH_BY_ID, $id);
        if(!$detail){
            return ['status'=>-2, 'desc'=>'数据不存在或无权限'];
        }

        //获取远端数据
        $post_result = $this->model_sign->sms_template_check([$detail['template_id']]);
        //如果取返回值成功，则更新DB
        if(isset($post_result['status'])){
            //更新提交结果
            $result = $model->update($detail['id'], [
                'verify_status'   => $post_result['status'],
                'verify_desc'     => $post_result['msg'],
                'update_at'     => time(),
            ]);
            if($result){
                return ['status'=>1, 'desc'=>'检查成功'];
            } else {
                return ['status'=>1, 'desc'=>'检查成功,保存本地失败'];
            }
        }

        return ['status'=>-1, 'desc'=>'检查失败'];
    }

}