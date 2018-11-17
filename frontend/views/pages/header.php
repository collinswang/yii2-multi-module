<?php
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="ft_header" id="appHeader">
    <div class="ft_header_wp clearfix">
        <div class="ft_logo">
            <h1>
                <a href="/" title="返回首页"><img src="/pages/images/logo.png" alt="云之讯开放平台"
                                              onclick="_hmt.push(['_trackEvent', '官网', 'click', '顶部menu菜单_本层_顶部_图片_logo首页'])"></a>
            </h1>
        </div>
        <div class="ft_log">
            <?php if(Yii::$app->getUser()->getIsGuest()){?>
            <span class="ft_header_nologin">
                <?=Html::a('登录',  Url::toRoute(['/site/login']), ['class'=>'log', 'id'=>'pubLogin'])?>
                <?=Html::a('注册有礼',  Url::toRoute(['/site/reg']), ['class'=>'reg', 'id'=>'pubRegister'])?>
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
                <li t_nav="home" id="pubHome"><a href="/service/sms_promote.html" target="_blank">最新活动</a>
                </li>
                <li t_nav="product"><a href="javascript:void(0)" id="pubAppAndService">产品</a></li>
                <li t_nav="experience"><a href="/experience" target="_blank" id="pubService">免费体验</a>
                </li>
                <li t_nav="support"><a href="javascript:void(0)" id="pubDoc">技术支持</a>
                </li>
                <li t_nav="headerAdv"><a href="/about/index.html" target="_blank" id="pubZone">关于我们</a>
                </li>
            </ul>

        </div>

    </div>
</div>