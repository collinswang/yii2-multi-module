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

$this->title = yii::t('frontend', 'Sign up') . '-' . yii::$app->feehi->website_title;
$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag(['keywords' => yii::$app->feehi->seo_keywords]);
$this->registerMetaTag(['description' => yii::$app->feehi->seo_description]);
?>
<div class="content-wrap">
    <div class="site-signup article-content" style="width:500px; margin: 0 auto">
        <h1><?= Html::encode($this->title) ?></h1>
        <style>
            label {
                float: left;
                width: 100px
            }
            .table_captcha td{
                padding-right: 5px;
            }
        </style>
        <p><?= yii::t('frontend', 'Please fill out the following fields to signup') ?>:</p>

        <div class="row">
            <div class="col-lg-8">
                <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

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
                    <?= Html::submitButton(yii::t('frontend', 'Signup'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
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
            data:'&SignupForm[username]='+mobile+'&SignupForm[captcha]='+captcha+'&_csrf='+$("input[name=_csrf]").val(),
            type:1,
            method:'post',
            success:function (data) {
                if(data.status==0){
                    console.log(data);
                    $("#sendSmsResult").html();
                    $(".field-captcha").removeClass('has-error');
                } else {
                    if(data.msg.captcha){
                        $("#sendSmsResult").html(data.msg.captcha);
                        $(".field-captcha").addClass('has-error');
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
</script>
