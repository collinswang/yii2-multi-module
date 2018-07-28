<?php

use backend\widgets\Bar;
use backend\grid\CheckboxColumn;
use backend\grid\ActionColumn;
use backend\grid\GridView;
use common\modules\sms\data\SmsTemplateData;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sms Templates';
$this->params['breadcrumbs'][] = 'Sms Templates';
?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <?= $this->render('/widgets/_ibox-title') ?>
            <div class="ibox-content">
                <?= Bar::widget() ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        ['class' => CheckboxColumn::className()],

                        'id',
                        'title',
                        [
                            'label'=>'source',
                            'attribute'=>'source',
                            'value'=>function ($data) {
                                return SmsTemplateData::$source[$data->source]; // 如果是数组数据则为 $data['name'] ，例如，使用 SqlDataProvider 的情形。
                            },
                        ],
                        'template_id',
                        'content',
                        // 'desc',
                        // 'create_at',
                        // 'update_at',
                        // 'verify_desc',
                        // 'is_hidden',
                        [
                            'label'=>'type',
                            'attribute'=>'type',
                            'value'=>function ($data) {
                                return SmsTemplateData::$type[$data->type]; // 如果是数组数据则为 $data['name'] ，例如，使用 SqlDataProvider 的情形。
                            },
                        ],
                        [
                            'label'=>'verify_status',
                            'value'=>function ($data) {
                                return SmsTemplateData::$verify_status[$data->verify_status]; // 如果是数组数据则为 $data['name'] ，例如，使用 SqlDataProvider 的情形。
                            },
                        ],
                        ['class' => ActionColumn::className(),],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
