<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\modules\finance\models\FinanceIncome */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Finance Incomes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="finance-income-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'id',
            'uid',
            'payable',
            'fee_rate',
            'fee',
            'received',
            'create_time:datetime',
            'deal_time:datetime',
            'type',
            'status',
            'admin_id',
            'admin_note',
            'invisible',
        ],
    ]) ?>

</div>
