<?php

use backend\widgets\Bar;
use backend\grid\CheckboxColumn;
use backend\grid\ActionColumn;
use backend\grid\GridView;
use common\modules\sms\data\SmsData;
use common\modules\sms\models\SmsSearch;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\sms\models\SmsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sms';
$this->params['breadcrumbs'][] = 'Sms';
?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <?= $this->render('/widgets/_ibox-title') ?>
            <div class="ibox-content">
                <?= Bar::widget([
//                    'template' => '{refresh} {delete}'
                ]) ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => CheckboxColumn::className()],
                        'id',
                        'uid',
                        [
                            'label'=>'source',
                            'attribute' => 'source',
                            'value'=>function ($data) {
                                return SmsData::$source[$data->source]; // 如果是数组数据则为 $data['name'] ，例如，使用 SqlDataProvider 的情形。
                            },
                        ],
//                        [
//                            'label'=>'type',
//                            'attribute' => 'type',
//                            'value'=>function ($data) {
//                                return SmsData::$type[$data->type]; // 如果是数组数据则为 $data['name'] ，例如，使用 SqlDataProvider 的情形。
//                            },
//                        ],
                        [
                            'label'=>'手机',
                            'attribute' => 'mobile',
                            'headerOptions' => ['width'=>'100px'],
                        ],
//                        'template_id',
                        [
                            'label'=>'内容',
                            'attribute' => 'content',
                            'headerOptions' => ['width'=>'20%'],
                        ],
                        [
                            'class'=> \backend\grid\DateColumn::className(),
                            'label'=>'create_at',
                            'attribute' => 'create_at',
                        ],
                        // 'update_at',
                        [
                            'label'=>'send_status',
                            'attribute' => 'send_status',
                            'value'=>function ($data) {
                                return SmsData::$send_status[$data->send_status]; // 如果是数组数据则为 $data['name'] ，例如，使用 SqlDataProvider 的情形。
                            },
                        ],
                        // 'send_desc',
                        // 'is_hidden',
                         'sid',
                        // 'order_id',

                        ['class' => ActionColumn::className(),
                         'template' => '{view-layer}{delete}'
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
