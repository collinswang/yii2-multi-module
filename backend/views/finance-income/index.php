<?php

use backend\widgets\Bar;
use backend\grid\CheckboxColumn;
use backend\grid\ActionColumn;
use backend\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\finance\models\FinanceIncomeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '充值流水';
$this->params['breadcrumbs'][] = '充值流水';
?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <?= $this->render('/widgets/_ibox-title') ?>
            <div class="ibox-content">
                <?= Bar::widget() ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
//                        ['class' => CheckboxColumn::className()],

                        'id',
                        'uid',
                        [
                            'attribute'=> 'received',
                            'label' => '充值金额',
                        ],
                        //'fee_rate',
                        //'fee',
                        // 'received',
                         'create_time:datetime:创建时间',
                         'deal_time:datetime:支付时间',
                        // 'type',
                        // 'status',
                        // 'admin_id',
                        // 'admin_note',
                        // 'invisible',

//                        [
//                            'class' => ActionColumn::className(),
//                            'template' => '{view}',
//                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
