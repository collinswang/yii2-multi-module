<?php

use backend\widgets\Bar;
use backend\grid\CheckboxColumn;
use backend\grid\ActionColumn;
use backend\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\finance\models\FinanceAccountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户资产列表';
$this->params['breadcrumbs'][] = '用户资产列表';
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

                        'uid',
                        [
                            'attribute'=>'total_usable',
                            'label'=>'可用余额',

                        ],
                        [
                            'attribute'=>'total_income',
                            'label'=>'总充值金额',

                        ],
                        [
                            'attribute'=>'total_outcome',
                            'label'=>'总消费金额',

                        ],
//                        [
//                            'attribute'=>'total_award',
//                            'label'=>'总赠送金额',
//
//                        ],
                        // 'total_withdraw',
                        // 'total_return',
                        // 'status',
                        // 'admin_id',
                        // 'admin_note',
                         'last_time:datetime:最后更新时间',

                        [
                            'class' => ActionColumn::className(),
                            'buttons' => [
                                'finance' => function ($url, $model, $key) {
                                    return Html::a('<i class="fa  fa-commenting-o" aria-hidden="true"></i> 流水',
                                        Url::to([
                                            'finance-flow/index',
                                            'FinanceFlowSearch[uid]' => $model->uid
                                        ]), [
                                            'class' => 'btn btn-white btn-sm',
                                        ]);
                                },
                            ],
                            'template' => '{finance}',
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
