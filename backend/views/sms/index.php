<?php

use backend\widgets\Bar;
use backend\grid\CheckboxColumn;
use backend\grid\ActionColumn;
use backend\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sms';
$this->params['breadcrumbs'][] = 'Sms';
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
                        'uid',
                        'type',
                        'mobile',
                        'template_id',
                        // 'content',
                        // 'create_at',
                        // 'update_at',
                        // 'send_status',
                        // 'send_desc',
                        // 'is_hidden',
                        // 'sid',
                        // 'order_id',

                        ['class' => ActionColumn::className(),],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
