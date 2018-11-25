<?php

use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model common\modules\finance\models\FinanceFlow */

$this->params['breadcrumbs'] = [
    ['label' => yii::t('app', 'Finance Flow'), 'url' => Url::to(['index'])],
    ['label' => yii::t('app', 'Create') . yii::t('app', 'Finance Flow')],
];
?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>

