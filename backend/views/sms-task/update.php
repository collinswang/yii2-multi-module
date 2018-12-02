<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\modules\sms\models\SmsTask */

$this->params['breadcrumbs'] = [
    ['label' => yii::t('app', 'Sms Task'), 'url' => Url::to(['index'])],
    ['label' => yii::t('app', 'Update') . yii::t('app', 'Sms Task')],
];
?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>
