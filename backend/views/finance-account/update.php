<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\modules\finance\models\FinanceAccount */

$this->params['breadcrumbs'] = [
    ['label' => yii::t('app', 'Finance Account'), 'url' => Url::to(['index'])],
    ['label' => yii::t('app', 'Update') . yii::t('app', 'Finance Account')],
];
?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>
