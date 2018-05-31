<?php

use backend\widgets\ActiveForm;
use common\modules\sms\data\SmsTemplateData;

/* @var $this yii\web\View */
/* @var $model common\modules\sms\models\SmsTemplate */
/* @var $form backend\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <?= $this->render('/widgets/_ibox-title') ?>
            <div class="ibox-content">
                <?php $form = ActiveForm::begin([
                    'options' => [
                        'class' => 'form-horizontal'
                    ]
                ]); ?>
                <div class="hr-line-dashed"></div>
                    <?= $form->field($model, 'uid')->textInput() ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'source')->dropDownList(SmsTemplateData::$source) ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'template_id')->textInput(['maxlength' => true]) ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'content')->textInput(['maxlength' => true]) ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'desc')->textInput(['maxlength' => true]) ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'verify_status')->dropDownList(SmsTemplateData::$verify_status) ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'verify_desc')->textInput(['maxlength' => true]) ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'is_hidden')->textInput() ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'type')->dropDownList(SmsTemplateData::$type) ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->defaultButtons() ?>
                    <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>