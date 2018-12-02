<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\sms\models\SmsTaskSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sms-task-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'uid') ?>

    <?= $form->field($model, 'source') ?>

    <?= $form->field($model, 'template_id') ?>

    <?= $form->field($model, 'total') ?>

    <?php // echo $form->field($model, 'total_success') ?>

    <?php // echo $form->field($model, 'create_at') ?>

    <?php // echo $form->field($model, 'update_at') ?>

    <?php // echo $form->field($model, 'is_hidden') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'file') ?>

    <?php // echo $form->field($model, 'single_price') ?>

    <?php // echo $form->field($model, 'total_price') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
