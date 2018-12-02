<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\modules\finance\models\FinanceAccount */

$this->title = $model->uid;
$this->params['breadcrumbs'][] = ['label' => 'Finance Accounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="finance-account-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->uid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->uid], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'uid',
            'total_usable',
            'total_income',
            'total_award',
            'total_outcome',
            'total_withdraw',
            'total_return',
            'status',
            'admin_id',
            'admin_note',
            'last_time:datetime',
        ],
    ]) ?>

</div>
