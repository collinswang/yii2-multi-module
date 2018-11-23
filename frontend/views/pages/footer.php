<?php
use yii\helpers\Url;
use common\models\FriendlyLink;
?>
<!--右下角功能菜单-->
<div class="pub-r-b-fun-content" id="pubRightFunctionContent">
    <ul class="pub-fun-list">
        <li class="item online">
            <a href="javascript:void(0);" class="js-qq-link" id="">在线咨询</a>
        </li>
        <li class="item tel">
            <a href="javascript:void(0);"  id="pubTelAskFor">
                电话咨询
                <div class="pub-fun-tip">
                    <span class="arrow"></span>
                    请拨打(010)5843-5890
                </div>
            </a>
        </li>
        <li class="item feedback">
            <a href="https://www.wenjuan.com/s/neYnqe/" target="_blank">意见反馈</a>
        </li>
        <li class="item to-top js-to-top"  id="pubGoToTop">
            <a href="javascript:void(0);">TOP</a>
        </li>
    </ul>
</div>
<!--右下角功能菜单 eof-->

<div class="ft_footer">
    <div class="footer_box">
        <div class="footer_add_wp">
            <ul class="clearfix">
                <li class="item item1"><img src="/pages/images/foot-bm-phone.gif" alt="电话图标" />服务咨询<span>(010)5843-5890</span></li>
                <li class="item item2">一对一贵宾级服务</li>
                <li class="item item3">7X24小时技术保障</li>
            </ul>
        </div>
    </div>
    <div class="footer_link">
        <div class="ft_footer_wp clearfix">
            <ul class="foot_nav">
                <li><a href="<?= Url::toRoute(['/page/view', 'name'=>'notice_letter'])?>">通知短信</a></li>
                <li><a href="<?=Url::toRoute(['/page/view', 'name'=>'spread_letter'])?>">营销短信</a></li>
                <li><a href="<?=Url::toRoute(['/article/list', 'cat'=>'help'])?>">使用帮助</a></li>
                <li><a href="<?=Url::toRoute(['/article/list', 'cat'=>'news'])?>">新闻中心</a></li>
                <li><a href="<?=Url::toRoute(['/article/list', 'cat'=>'case'])?>">成功案例</a></li>
                <li><a href="<?=Url::toRoute(['/page/view', 'name'=>'about'])?>">关于我们</a>
            </ul>
<!--            <ul class="share">-->
<!--                <li style="flex:5; text-align: right">关注云提醒</li>-->
<!--                <li style="flex:2; text-align: center">-->
<!--                    <img src="/pages/images/wx_code.png"/>-->
<!--                </li>-->
<!--                <li style="flex:5; text-align: left">云提醒官方微信</li>-->
<!--            </ul>-->
        </div>
        <div class="relate_links">
            <div class="relate_wp">
                <span>友情链接</span><i class="first"></i>
                <?php
                $links = FriendlyLink::find()->where(['status' => FriendlyLink::DISPLAY_YES])->orderBy("sort asc, id asc")->asArray()->all();
                foreach ($links as $link) {
                    echo "<a target='_blank' href='{$link['url']}'>{$link['name']}</a><i></i>";
                }
                ?>
            </div>
        </div>

        <div class="copyright">
            <div class="ft_footer_wp">
                <p>
                    2018 北京世恒绿都科技有限公司
                    <span class="icp"><a href="http://www.miitbeian.gov.cn/"  target="_blank">京ICP备18049487号</a></span>
                    <!--工商网监图标-->
                    <a href="#" target="_blank"><img src="/pages/images/govIcon.gif" width="18" height="25" border="0" style="border-width:0;border:none;"></a>
                    <!--工商网监图标-->

                </p>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript" src="/pages/js/jquery.flexslider-min.js"></script>
<script type="text/javascript" src="/pages/js/swiper.js"></script>
<script type="text/javascript" src="/pages/js/base.js"></script>

<script charset="utf-8" type="text/javascript" >
    $(function(){

        //咨询图标位置
        var h = $(window).height();
        $(".help_box").css("top",(h-106)*2/3);

        $(window).resize(function(){
            var h = $(window).height();
            $(".help_box").css("top",(h-106)*2/3);
        })
        $(".help_tel,.help_qq").hover(function(){
            $(this).find(".help_list").animate({ right: 90, opacity: 'show'}, { duration: 200 });
        },function(){
            $(this).find(".help_list").animate({ right: 0, opacity: 'hide'}, { duration: 200 });
        })
    })
</script>

<script type="text/javascript" src="/pages/js/index.js"></script>