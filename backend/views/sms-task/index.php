<?php

use backend\widgets\Bar;
use backend\grid\CheckboxColumn;
use backend\grid\ActionColumn;
use backend\grid\GridView;
use common\modules\sms\data\SmsTaskData;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\sms\models\SmsTaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sms Tasks';
$this->params['breadcrumbs'][] = 'Sms Tasks';
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
                            'attribute' => 'source',
                            'label' => '发送渠道',
                            'value' => function($model){
                                return SmsTaskData::$source[$model->source];
                            }
                        ],
                        [
                            'attribute' => 'template_id',
                            'label' => '模板ID',
                        ],
                        [
                            'attribute' => 'total',
                            'label' => '发送条数',
                        ],
                        [
                            'attribute' => 'single_price',
                            'label' => '单价(分)',
                        ],
                        [
                            'attribute' => 'total_price',
                            'label' => '总价(分)',
                        ],
                        [
                            'attribute' => 'status',
                            'label' => '发送状态',
                            'value' => function($model){
                                return SmsTaskData::$status_arr[$model->status];
                            }
                        ],
                        // 'total_success',
                        // 'create_at',
                         'update_at:datetime:最后更新时间',
                        // 'is_hidden',
                        // 'status',
                        // 'file',
                        // 'single_price',
                        // 'total_price',

//                        ['class' => ActionColumn::className(),],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
