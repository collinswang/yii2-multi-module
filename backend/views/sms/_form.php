<?php

use backend\widgets\ActiveForm;
use common\modules\sms\data\SmsData;
use common\widgets\JsBlock;

/* @var $this yii\web\View */
/* @var $model common\modules\sms\models\Sms */
/* @var $form backend\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <?= $this->render('/widgets/_ibox-title') ?>
            <div class="ibox-content">
                <?php $form = ActiveForm::begin([
                    'options' => [
                        'class' => 'form-horizontal'
                    ]
                ]); ?>
                <div class="hr-line-dashed"></div>
                    <?= $form->field($model, 'uid')->textInput() ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'source')->dropDownList(SmsData::$source, ['prompt' => '-- none --',
                                                                                                     'class' => 'form-control ajax-source',]) ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'type')->textInput() ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'mobile')->textInput() ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'template_id')->dropDownList($template_list, ['id'=>'template']) ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'content')->textInput(['id'=>'content', 'maxlength' => true]) ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'create_at')->textInput() ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'update_at')->textInput() ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'send_status')->textInput() ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'send_desc')->textInput(['maxlength' => true]) ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'is_hidden')->textInput() ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'sid')->textInput() ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'order_id')->textInput() ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->defaultButtons() ?>
                    <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<?php JsBlock::begin() ?>
    <script>
        $('.ajax-source').on('change', function () {
            var source = $(this).val(); // form of the dropdown
            console.log(source);
            $.ajax({
                url: '<?=\yii\helpers\Url::toRoute(['sms/get-template-list'])?>',
                data: 'type='+source,
                success: function (response) {
                    $('#template').empty();
                    $('#template').append("<option value=0>请选择</option>");
                    $.each(response, function (k, v) {
                        $('#template').append("<option value='"+k+"'>"+v+"</option>");
                        console.log(k, v);
                    });
                },
                error: function () {
                    console.log(response);
                    alert('Error: There was an error whilst processing this request.');
                }
            });
            return false;
        });
        $('#template').on('change', function () {
            $('#content').val($("#template option:selected").text());
        });
    </script>
<?php JsBlock::end() ?>