<?php

use backend\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\finance\models\FinanceFlow */
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

                        <?= $form->field($model, 'money')->textInput(['maxlength' => true]) ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'target_type')->textInput() ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'target_id')->textInput() ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'create_time')->textInput() ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'invisible')->textInput() ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->defaultButtons() ?>
                    <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>