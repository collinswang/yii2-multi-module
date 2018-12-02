<?php

use backend\widgets\Bar;
use backend\grid\CheckboxColumn;
use backend\grid\ActionColumn;
use backend\grid\GridView;
use common\modules\finance\data\FinanceFlowData;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\finance\models\FinanceFlowSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户资金流水表';
$this->params['breadcrumbs'][] = '用户资金流水表';
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
                            'attribute'=>'money',
                            'label'=>'变动金额',

                        ],
                        [
                            'attribute'=>'target_type',
                            'label'=>'变更类型',
                            'value' => function($model){
                                return FinanceFlowData::$target_type[$model->target_type];
                            }

                        ],
                        [
                            'attribute'=>'target_id',
                            'label'=>'变动目标ID',

                        ],
                         'create_time:datetime:变更时间',
                        // 'invisible',

//                        ['class' => ActionColumn::className(),],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
