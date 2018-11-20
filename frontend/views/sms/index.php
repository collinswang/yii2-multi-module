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
use common\modules\sms\data\SmsData;
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

$this->title = '短信发送记录';
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
                        //'uid',
                        //'source',
                        //'type',
                        [
                            'attribute'=>'mobile',
                            'label' => '手机号',
                        ],
                        // 'template_id',
                        [
                            'attribute'=>'content',
                            'label' => '短信参数',
                            'format' => 'html',
                            'value' => function($model){
                                $string = '';
                                $arr = json_decode($model->content, true);
                                foreach ($arr as $key => $value) {
                                    $string .= "{$key}\t:\t{$value}<br>";
                                }
                                return $string;
                            }
                        ],
                        // 'create_at',
                        // 'update_at',
                        [
                            'attribute'=>'send_status',
                            'label' => '发送状态',
                            'value' => function($model){
                                return SmsData::$send_status[$model->send_status];
                            }
                        ],
                        // 'send_desc',
                        // 'is_hidden',
                        // 'sid',
                        // 'task_id',
                    ],
                ]); ?>

            </div>
        </div>
    </div>
</div>