<?php

use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model common\modules\sms\models\SmsTemplate */

$this->params['breadcrumbs'] = [
    ['label' => yii::t('app', 'Sms Template'), 'url' => Url::to(['index'])],
    ['label' => yii::t('app', 'Create') . yii::t('app', 'Sms Template')],
];
?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>

