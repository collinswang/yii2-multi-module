<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-03-23 17:51
 */

/**
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $searchModel backend\models\search\ArticleSearch
 */

use backend\grid\DateColumn;
use backend\grid\GridView;
use backend\grid\SortColumn;
use common\modules\sms\data\SmsTaskData;
use common\widgets\JsBlock;
use yii\helpers\Url;
use common\models\Category;
use common\libs\Constants;
use yii\helpers\Html;
use backend\widgets\Bar;
use yii\widgets\Pjax;
use backend\grid\CheckboxColumn;
use backend\grid\ActionColumn;
use backend\grid\StatusColumn;

$this->title = '知信发送任务列表';
$this->params['breadcrumbs'][] = yii::t('app', 'Task List');

?>
<style>
    select.form-control {
        padding: 0px
    }
</style>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <?= $this->render('/widgets/_ibox-title') ?>
            <div class="ibox-content">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        'id',
                        [
                            'attribute'=>'template_id',
                            'label' => '模板ID'
                        ],
                        [
                            'attribute'=>'total',
                            'label' => '发送数量'
                        ],
                        [
                            'attribute'=>'total_price',
                            'label' => '费用(元)',
                            'value' => function($model){
                                return $model->total_price/100;
                            }
                        ],
                        [
                            'class' => DateColumn::className(),
                            'attribute' => 'create_at',
                            'label' => '创建时间',
                        ],
                        [
                            'attribute' => 'status',
                            'filter' => SmsTaskData::$status_arr,
                            'label'=> '当前状态',
                            'value' => function($model){
                                return SmsTaskData::$status_arr[$model->status];
                            }
                        ],
                        // 'total_success',
                        // 'create_at',
                        // 'update_at',
                        // 'is_hidden',
                        // 'status',
                        // 'file',
                        // 'single_price',
                        // 'total_price',

                        [
                            'class' => ActionColumn::className(),
                            'buttons' => [
                                'confirm' => function ($url, $model, $key) {
                                    if($model->status == SmsTaskData::STATUS_PEDING) {
                                        return Html::a('<i class="fa  fa-commenting-o" aria-hidden="true"></i> 确认',
                                            Url::to([
                                                'sms/confirm',
                                                'task_id' => $model->id
                                            ]), [
                                                'class' => 'btn btn-white btn-sm',
                                            ]);
                                    }
                                },
                                'detail' => function($url, $model, $key){
                                    if($model->status == SmsTaskData::STATUS_SUCCESS){
                                        return Html::a('<i class="fa  fa-commenting-o" aria-hidden="true"></i> 详情', Url::to([
                                            'sms/index',
                                            'task_id' => $model->id
                                        ]), [
                                            'class' => 'btn btn-white btn-sm',
                                        ]);
                                    }
                                }
                            ],
                            'template' => '{confirm}{detail}',
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>