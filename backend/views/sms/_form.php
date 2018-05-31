<?php

use backend\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\sms\models\Sms */
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

                        <?= $form->field($model, 'type')->textInput() ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'mobile')->textInput() ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'template_id')->textInput() ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'content')->textInput(['maxlength' => true]) ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'create_at')->textInput() ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'update_at')->textInput() ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'send_status')->textInput() ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'send_desc')->textInput(['maxlength' => true]) ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'is_hidden')->textInput() ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'sid')->textInput() ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->defaultButtons() ?>
                    <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>