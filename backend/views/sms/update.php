<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\modules\sms\models\Sms */

$this->params['breadcrumbs'] = [
    ['label' => yii::t('app', 'Sms'), 'url' => Url::to(['index'])],
    ['label' => yii::t('app', 'Update') . yii::t('app', 'Sms')],
];
?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>
