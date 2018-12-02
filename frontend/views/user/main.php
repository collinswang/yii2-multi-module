<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-03-31 14:17
 */
use backend\grid\GridView;
use common\modules\finance\data\FinanceFlowData;
use common\widgets\JsBlock;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <div class="ibox-title">
                <span class="label label-success pull-right">最后更新时间:<?=$account['last_time']?></span>
                <h5>当前余额</h5>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-sm-6"><h1><?= $account['total_usable']?$account['total_usable']:'0' ?>元</h1></div>
                    <div class="col-sm-3 col-sm-offset-3"><?= Html::a('充值', ['recharge'], ['class' =>'btn btn-danger'])?></div>
                </div>
            </div>
        </div>
    </div>
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
                            'attribute'=>'target_type',
                            'label'=>'操作类型',
                            'format'=>'raw',
                            'value' => function($model){
                                return FinanceFlowData::$target_type[$model->target_type]."(".$model->target_id.")";
                                //return Html::a(FinanceFlowData::$target_type[$model->target_type]."(".$model->target_id.")", [FinanceFlowData::get_target_detail($model->target_type), 'id'=>$model->target_id]);
                            }
                        ],
                        [
                            'attribute'=>'money',
                            'label'=>'金额(元)',
                        ],
                        [
                            'attribute'=>'create_time',
                            'label'=>'操作时间',
                            'format'=>'datetime',
                        ],
                        // 'invisible',
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
<?php JsBlock::begin() ?>
<script>

</script>
<?php JsBlock::end() ?>
