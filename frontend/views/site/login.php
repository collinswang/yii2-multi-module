<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-03-15 21:16
 */

/* @var $this yii\web\View */
/* @var $form \yii\bootstrap\ActiveForm*/
/* @var $model \common\models\LoginForm */

use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->registerMetaTag(['keywords' => yii::$app->feehi->seo_keywords]);
$this->registerMetaTag(['description' => yii::$app->feehi->seo_description]);

$this->title = yii::t('app', 'Login') . '-' . yii::$app->feehi->website_title;
$this->params['breadcrumbs'][] = $this->title;
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
    .site-login{
        width: 400px;
        padding: 20px;
        background: #eeeeee;
        margin: 0 auto;
    }
    .center{text-align: center;}
</style>
<div class="content-wrap">
    <div class="site-login article-content">
        <h1 class="center"><?= Html::encode($this->title) ?></h1>
        <div class="row">
            <div class="col-lg-5">
                <?php $form = ActiveForm::begin(['id' => 'form-login']); ?>

                <?= $form->field($model, 'username', ['template' => "<div style='position:relative'>{label}{input}\n{error}\n{hint}</div>"])->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password', ['template' => "<div style='position:relative'>{label}{input}\n{error}\n{hint}</div>"])->passwordInput() ?>

                <?= $form->field($model, 'captcha', ['template' => '<div style="position:relative">{label}{input}{error}{hint}</div>'])->widget(Captcha::classname(), [
                    'template' => '<table class="table_captcha"><tr><td>{input}</td><td>{image}</td></tr></table>',
                    'options' => [
                        "class"=>"form-control",
                        'id' =>'captcha',
                    ],
                    'imageOptions' => [
                        //"style" => "cursor:pointer;right:0px;"
                    ]
                ]) ?>

                <?= $form->field($model, 'rememberMe')->checkbox()?>

                <div class="form-group" style="color:#999;">
                    <?= yii::t('frontend', 'If you forgot your password you can') ?> <?= Html::a(yii::t('frontend', 'reset it'), ['site/reset']) ?>
                </div>

                <div class="form-group" style="margin-right: 50px">
                    <?= Html::submitButton(yii::t('frontend', 'Login'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
