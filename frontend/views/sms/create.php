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

$this->title = '短信群发';
$template_list = SmsTemplate::find()->asArray()->all();

$templates = [];
$template_contents = [];
foreach ($template_list as $item) {
    $templates[$item['id']] = $item['title'];
    $template_contents[$item['id']] = $item['content'];
}

?>
<div class="col-sm-12">
    <div class="ibox">
        <?= $this->render('/widgets/_ibox-title') ?>
        <div class="ibox-content">

            <?php $form = ActiveForm::begin([
                'options' => [
                    'enctype' => 'multipart/form-data',
                    'class' => 'form-horizontal'
                ]
            ]); ?>
            <?= $form->field($model, 'template_id')->dropDownList($templates); ?>
            <div class="hr-line-dashed"></div>
            <?=$form->field($model, "file", ['options'=>['class'=>"form-group input_3"]])->fileInput();?>
            <div class="hr-line-dashed"></div>
            <?= $form->defaultButtons() ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
