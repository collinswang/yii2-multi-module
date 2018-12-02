<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\modules\finance\models\FinanceIncome */

$this->params['breadcrumbs'] = [
    ['label' => yii::t('app', 'Finance Income'), 'url' => Url::to(['index'])],
    ['label' => yii::t('app', 'Update') . yii::t('app', 'Finance Income')],
];
?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>
