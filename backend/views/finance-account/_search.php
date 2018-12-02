<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\finance\models\FinanceAccountSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="finance-account-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'uid') ?>

    <?= $form->field($model, 'total_usable') ?>

    <?= $form->field($model, 'total_income') ?>

    <?= $form->field($model, 'total_award') ?>

    <?= $form->field($model, 'total_outcome') ?>

    <?php // echo $form->field($model, 'total_withdraw') ?>

    <?php // echo $form->field($model, 'total_return') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'admin_id') ?>

    <?php // echo $form->field($model, 'admin_note') ?>

    <?php // echo $form->field($model, 'last_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
