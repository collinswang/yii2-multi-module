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
use common\libs\Constants;
use common\modules\sms\models\SmsTemplate;
use common\widgets\JsBlock;

$this->title = '短信群发';
$template_list = SmsTemplate::find()->asArray()->all();

$templates = [];
$template_contents = [];
foreach ($template_list as $item) {
    $templates[$item['id']] = $item['title'];
    $template_contents[$item['id']] = $item['content'];
}

?>
<style>
    #temp_content{font-size: 14px;}
</style>
<div class="col-sm-12">
    <div class="ibox">
        <?= $this->render('/widgets/_ibox-title') ?>
        <div class="ibox-content">

            <?php $form = ActiveForm::begin([
                'options' => [
                    'enctype' => 'multipart/form-data',
                    'class' => 'form-horizontal'
                ]
            ]); ?>
            <?= $form->field($model, 'template_id')->dropDownList($templates); ?>
            <div class="hr-line-dashed"></div>
            <?=$form->field($model, "file", ['options'=>['class'=>"form-group input_3"]])->fileInput();?>
            <div class="hr-line-dashed"></div>
            <?= $form->defaultButtons() ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<?php JsBlock::begin()?>
<script>
    <?php
    foreach ($template_contents as $key=>$template_content) {
        echo "var template{$key} = '{$template_content}';";
        }
    ?>
    $('#smstaskform-template_id').bind('change', function () {
        var temp_id = 'template'+$(this).val();
        $("#temp_content").remove();
        $(this).parent().append('<div id="temp_content">'+eval(temp_id)+'</div>');
    });
</script>
<?php JsBlock::end()?>
