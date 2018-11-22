<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-12-05 13:00
 */

/**
 * @var $this yii\web\View
 * @var $model frontend\models\User
 */
use backend\widgets\ActiveForm;
use common\libs\Constants;
use common\modules\sms\models\SmsTemplate;
use common\widgets\JsBlock;

$this->title = '个人信息';

?>
<div class="col-sm-12">
    <div class="ibox">
        <?= $this->render('/widgets/_ibox-title') ?>
        <div class="ibox-content">

            <?php $form = ActiveForm::begin([
                'options' => [
                    'class' => 'form-horizontal'
                    //'enctype' => 'multipart/form-data',
                ]
            ]); ?>
            <?= $form->field($model, 'username')->textInput(['readonly'=>'true']); ?>
            <div class="hr-line-dashed"></div>
            <?= $form->field($model, 'old_password')->textInput(); ?>
            <div class="hr-line-dashed"></div>
            <?= $form->field($model, 'password')->textInput(); ?>
            <div class="hr-line-dashed"></div>
            <?= $form->field($model, 'password_repeat')->textInput(); ?>
            <div class="hr-line-dashed"></div>
            <?= $form->defaultButtons() ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
