<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-03-15 21:16
 */

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use frontend\models\Menu;
use yii\helpers\Url;
use backend\assets\IndexAsset;

IndexAsset::register($this);
$this->title = yii::t('app', 'Backend Manage System');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="renderer" content="webkit">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="icon" href="<?= yii::$app->getRequest()->getHostInfo() ?>/favicon.ico" type="image/x-icon"/>
</head>
<body class="fixed-sidebar full-height-layout gray-bg" style="overflow:hidden">
<?php $this->beginBody() ?>
<div id="wrapper">
    <!--左侧导航开始-->
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="nav-close"><i class="fa fa-times-circle"></i>
        </div>
        <div class="sidebar-collapse">
            <ul class="nav" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element">
                        <span>
                            <img alt="image" class="img-circle" width="64px" height="64px" src="/static/images/profile_small.jpg"/>
                        </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear">
                                <span class="block m-t-xs">当前用户:<strong class="font-bold"><?= yii::$app->getUser()->getIdentity()->username.'<br>'.Yii::$app->getUser()->getId(); ?></strong></span>
                            </span>
                        </a>
                    </div>
                    <div class="logo-element">H+</div>
                </li>
                <?php
                $cacheDependencyObject = yii::createObject([
                    'class' => 'common\helpers\FileDependencyHelper',
                    'fileName' => 'frontend_menu.txt',
                ]);
                $dependency = [
                    'class' => 'yii\caching\FileDependency',
                    'fileName' => $cacheDependencyObject->createFile(),
                ];
                if ($this->beginCache('frontend_menu', [
                    'variations' => [
                        Yii::$app->language,
                        yii::$app->getUser()->getId()
                    ],
                    'dependency' => $dependency
                ])
                ) {
                    ?>
                    <?= Menu::getFrontendMenu(); ?>
                    <?php
                    $this->endCache();
                }
                ?>
            </ul>
        </div>
    </nav>
    <!--左侧导航结束-->
    <!--右侧部分开始-->
    <div id="page-wrapper" class="gray-bg dashbard-1">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header" style="width: 50%;">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li class="hidden-xs">
                        <a href="<?= yii::$app->params['site']['url'] ?>" target='_blank'><i class="fa fa-internet-explorer"></i> <?= yii::t('frontend', 'Modify Password') ?></a>
                    </li>
                    <li class="hidden-xs">
                        <a href="http://cms.feehi.com/help" class="J_menuItem" data-index="0"><i class="fa fa-cart-arrow-down"></i> <?= yii::t('frontend', 'Log out') ?></a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="row content-tabs">
            <button class="roll-nav roll-left J_tabLeft"><i class="fa fa-backward"></i>
            </button>
            <nav class="page-tabs J_menuTabs">
                <div class="page-tabs-content">
                    <a href="javascript:;" class="active J_menuTab" data-id="<?= Url::to(['user/main']) ?>"><?= yii::t('app', 'Home') ?></a>
                </div>
            </nav>
            <button class="roll-nav roll-right J_tabRight"><i class="fa fa-forward"></i></button>
            <div class="btn-group roll-nav roll-right">
                <button class="dropdown J_tabClose" data-toggle="dropdown"><?= yii::t('app', 'Close') ?><span class="caret"></span></button>
                <ul role="menu" class="dropdown-menu dropdown-menu-right">
                    <li class="J_tabShowActive"><a><?= yii::t('app', 'Locate Current Tab') ?></a></li>
                    <li class="divider"></li>
                    <li class="J_tabCloseAll"><a><?= yii::t('app', 'Close All Tab') ?></a></li>
                    <li class="J_tabCloseOther"><a><?= yii::t('app', 'Close Other Tab') ?></a></li>
                </ul>
            </div>
            <?= Html::a('<i class="fa fa fa-sign-out"></i>' . yii::t('app', 'Logout'), Url::toRoute('site/logout'), ['data-method'=>'post', 'class'=>'roll-nav roll-right J_tabExit'])?>
        </div>
        <div class="row J_mainContent" id="content-main">
            <iframe class="J_iframe" name="iframe0" width="100%" height="100%" src="<?= Url::to(['user/main']) ?>" frameborder="0" data-id="<?= Url::to(['site/main']) ?>" seamless></iframe>
        </div>
        <div class="footer">
            <div class="pull-right">&copy; 2015-<?=date('Y')?> <a href="#" target="_blank">CMS</a></div>
        </div>
    </div>
    <!--右侧部分结束-->
    <?php $this->endBody() ?>
</body>
<script>
    function reloadIframe() {
        var current_iframe = $("iframe:visible");
        current_iframe[0].contentWindow.location.reload();
        return false;
    }
    if (window.top !== window.self) {
        window.top.location = window.location;
    }
</script>
</html>
<?php $this->endPage() ?>
