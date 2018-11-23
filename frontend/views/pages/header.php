<?php
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="ft_header" id="appHeader">
    <div class="ft_header_wp clearfix">
        <div class="ft_logo">
            <h1>
                <a href="/" title="返回首页"><img src="/pages/images/logo.png" alt="云提醒开放平台"></a>
            </h1>
        </div>
        <div class="ft_log">
            <?php if(Yii::$app->getUser()->getIsGuest()){?>
            <span class="ft_header_nologin">
                <?=Html::a('登录',  Url::toRoute(['/site/login']), ['class'=>'log', 'id'=>'pubLogin'])?>
                <?=Html::a('注册',  Url::toRoute(['/site/reg']), ['class'=>'reg', 'id'=>'pubRegister'])?>
            </span>
            <?php } else { ?>
            <span class="ft_header_nologin">
                <?=Html::a('管理中心',  Url::toRoute(['/user/index']), ['class'=>'reg', 'id'=>'user_center'])?>
                <?=Html::a('退出登录',  Url::toRoute(['/site/login']), ['class'=>'log', 'id'=>'logout'])?>
			</span>
            <?php }?>
        </div>
        <div class="ft_nav">
            <ul class="clearfix">
                <li id="pubHome"><a href="/" target="_blank">首页</a></li>
                <li><a href="<?=Url::toRoute(['/page/view', 'name'=>'notice_letter'])?>">通知短信</a></li>
                <li><a href="<?=Url::toRoute(['/page/view', 'name'=>'spread_letter'])?>">营销短信</a></li>
                <li><a href="<?=Url::toRoute(['/article/list', 'cat'=>'help'])?>">使用帮助</a></li>
                <li><a href="<?=Url::toRoute(['/page/view', 'name'=>'about'])?>">关于我们</a>
                </li>
            </ul>

        </div>

    </div>
</div>