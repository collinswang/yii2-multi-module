<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-03-15 21:16
 */

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model frontend\models\form\SignupForm */

use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = yii::t('frontend', 'Reset Password') . '-' . yii::$app->feehi->website_title;
$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag(['keywords' => yii::$app->feehi->seo_keywords]);
$this->registerMetaTag(['description' => yii::$app->feehi->seo_description]);
?>
<style>
    label {
        float: left;
        width: 100px
    }
    .table_captcha{
        width: 100%;
    }
    .table_captcha td{
        padding-right: 5px;
    }
    .gray-bg{
        background: url("/static/images/bg-pattern.png"), linear-gradient(to left, #328944, #247cdc);
    }
    .site-signup{
        width: 400px;
        padding: 40px;
        background: #eeeeee;
        margin: 0 auto;
    }
    .center{text-align: center;}
</style>
<div class="content-wrap">
    <div class="site-signup article-content">
        <h1 class="center"><?= Html::encode($this->title) ?></h1>
        <p class="center"><?= yii::t('frontend', 'Please fill out the following fields to reset') ?>:</p>

        <div class="row">
            <div>
                <?php $form = ActiveForm::begin(['id' => 'form-reset']); ?>

                <?= $form->field($model, 'username', ['template' => "<div style='position:relative'>{label}{input}\n{error}\n{hint}</div>"])->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'captcha', ['template' => '<div style="position:relative">{label}{input}{error}{hint}</div>'])->widget(Captcha::classname(), [
                    'template' => '<table class="table_captcha"><tr><td>{input}</td><td>{image}</td><td>'.Html::button('获取验证码', ['id'=>'sendSms','class' => 'btn btn-primary']).'</td></tr><tr><td colspan="3" class="help-block help-block-error" id="sendSmsResult"></td></tr></table>',
                    'options' => [
                        "class"=>"form-control",
                        'id' =>'captcha',
                    ],
                    'imageOptions' => [
                        //"style" => "cursor:pointer;right:0px;"
                    ]
                ]) ?>

                <?= $form->field($model, 'verify_code', ['template' => "<div style='position:relative'>{label}{input}\n{error}\n{hint}</div>"])->textInput() ?>

                <?= $form->field($model, 'password', ['template' => "<div style='position:relative'>{label}{input}\n{error}\n{hint}</div>"])->textInput(['placeholder'=>'下次登录时的密码']) ?>
                <?= $form->field($model, 'password_repeat', ['template' => "<div style='position:relative'>{label}{input}\n{error}\n{hint}</div>"])->textInput(['placeholder'=>'再次输入登录密码']) ?>

                <div class="form-group" style="text-align: center">
                    <?= Html::submitButton(yii::t('frontend', 'Reset Password'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<script src="/static/js/jquery.min.js"></script>
<script>
    $("#sendSms").click(function () {
        var mobile = $('#signupform-username').val();
        var captcha = $('#captcha').val();
        console.log(mobile);
        $.get({
            url:'/?r=site/send-code',
            data:'&source=2&SignupForm[username]='+mobile+'&SignupForm[captcha]='+captcha+'&_csrf='+$("input[name=_csrf]").val(),
            type:1,
            method:'post',
            success:function (data) {
                if(data.status==0){
                    console.log(data);
                    $("#sendSmsResult").html("");
                    $(".field-captcha").removeClass('has-error');
                    $(".field-signupform-username p").html("");
                    $(".field-signupform-username").removeClass('has-error');
                    $("#captcha-image").click();
                    countDown(60);
                } else {
                    if(data.msg.captcha){
                        $("#sendSmsResult").html(data.msg.captcha);
                        $(".field-captcha").addClass('has-error');
                        $("#captcha-image").click();
                    }
                    if(data.msg.username){
                        $(".field-signupform-username p").html(data.msg.username);
                        $(".field-signupform-username").addClass('has-error');
                        $("#captcha-image").click();
                    }
                    console.log('fail:'+data.msg);
                }
            },
            error:function (data) {
                console.log('fail:'+data.msg);
            }
        })
    });


    function countDown(second) { // 如果秒数还是大于0，则表示倒计时还没结束
        var obj =  $("#sendSms");
        console.log(second);
        if (second >= 0) { // 获取默认按钮上的文字
            if (typeof buttonDefaultValue === 'undefined') {
                buttonDefaultValue = '获取验证码';
            } // 按钮置为不可点击状态
            obj.addClass("disable").prop('disabled', true);
            obj.html(buttonDefaultValue + '(' + second + ')');
            second--; // 一秒后重复执行
            setTimeout(function () {
                countDown(second);
            }, 1000); // 否则，按钮重置为初始状态
        } else { // 按钮置未可点击状态
            obj.removeClass("disable").prop('disabled', false);
            obj.html(buttonDefaultValue);
        }
    }
</script>
