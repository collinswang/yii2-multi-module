<?php

use backend\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\sms\models\SmsTask */
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

                        <?= $form->field($model, 'source')->textInput() ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'template_id')->textInput() ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'total')->textInput() ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'total_success')->textInput() ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'is_hidden')->textInput() ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'status')->textInput() ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'file')->textInput(['maxlength' => true]) ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'single_price')->textInput(['maxlength' => true]) ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'total_price')->textInput(['maxlength' => true]) ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->defaultButtons() ?>
                    <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>