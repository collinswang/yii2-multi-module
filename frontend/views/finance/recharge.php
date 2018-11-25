<?php

use backend\widgets\ActiveForm;
use common\modules\finance\data\FinanceIncomeData;
use yii\helpers\Html;

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
                        'class' => 'form-horizontal',
//                        'target'=>'_blank',
                        'id'    => 'pay',
                    ],
                ]); ?>
                <div class="hr-line-dashed"></div>
                <div class="form-group field-smstaskform-template_id required">
                    <label class="col-sm-2 control-label">充值渠道</label>
                    <div class="col-sm-10"><?= Html::radioList('type', null, FinanceIncomeData::$type_arr, ['class' => 'form-control']) ?></div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group field-smstaskform-template_id required">
                    <label class="col-sm-2 control-label">充值金额</label>
                    <div class="col-sm-10"><?= Html::input('text', 'total', 100, ['class' => 'form-control']) ?></div>
                </div>
                <div class="hr-line-dashed"></div>

                <?= $form->defaultButtons() ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>