<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-12-05 13:00
 */

/**
 * @var $this yii\web\View
 * @var $model frontend\models\User
 */
use backend\widgets\ActiveForm;
use common\modules\sms\models\SmsTemplate;
use yii\helpers\Html;

$this->title = '短信群发';
$template_list = SmsTemplate::find()->asArray()->all();

$templates = [];
$template_contents = [];
foreach ($template_list as $item) {
    $templates[$item['id']] = $item['title'];
    $template_contents[$item['id']] = $item['content'];
}

?>
<div class="col-sm-12">
    <div class="ibox">
        <?= $this->render('/widgets/_ibox-title') ?>
        <div class="ibox-content">
            <?php $form = ActiveForm::begin(['action'=>['sms/confirm', 'id'=>$id], 'method'=>'post','id' => 'form-confirm', 'class'=>'form-horizontal']); ?>
            <?= Html::input('hidden', 'task_id', $id)?>
            <div class="form-group field-adform-tips required">
                <label class="col-sm-2 control-label" for="total">发送数量</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="total" value="<?=$info['total']?>" aria-required="true" disabled="disabled">
                </div>
            </div>
            <div class="hr-line-dashed"></div>

            <div class="form-group field-adform-tips required">
                <label class="col-sm-2 control-label" for="single_price">每条价格(元)</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="single_price" value="<?=$info['single_price']/100?>" aria-required="true" disabled="disabled">
                </div>
            </div>
            <div class="hr-line-dashed"></div>

            <div class="form-group field-adform-tips required">
                <label class="col-sm-2 control-label" for="total_price">合计价格(元)</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="total_price" value="<?=$info['total_price']/100?>" aria-required="true" disabled="disabled">
                </div>
            </div>
            <div class="hr-line-dashed"></div>

            <div class="form-group field-adform-tips required <?php if($finance['total_usable'] < $info['total_price']/100){ echo 'has-error';}?>">
                <label class="col-sm-2 control-label" for="total_usable">帐户当前余额:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="total_usable" value="<?=$finance['total_usable']?>" aria-required="true" disabled="disabled">
                </div>
                <div class="col-sm-1"><?=Html::a('充值', ['finance/income'], ['class'=>'btn btn-danger'])?></div>
            </div>
            <div class="hr-line-dashed"></div>

            <div class="form-group field-adform-tips required">
                <label class="col-sm-2 control-label" for="adform-tips">短信预览</label>
                <div class="col-sm-10">
                    <table>
                        <?php if($list){
                            foreach ($list as $item) {
                                echo "<tr><td>{$item['mobile']}</td><td>{$item['content']}</td></tr>";
                            }
                        }
                        ?>

                    </table>
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <?= $form->defaultButtons(['value'=>'确认执行任务']) ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
