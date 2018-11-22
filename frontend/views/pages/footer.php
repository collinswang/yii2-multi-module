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
            <dl>
                <dt>公司</dt>
                <dd><a href="/about/index.html#cert" onclick="_hmt.push(['_trackEvent', '官网', 'click', '底部菜单_本层_底部_文字链_公司资质'])">公司资质</a></dd>
                <dd><a href="/about/index.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '底部菜单_本层_底部_文字链_关于我们'])">关于我们</a></dd>
                <dd><a href="/about/partners.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '底部菜单_本层_底部_文字链_合作伙伴'])">合作伙伴</a></dd>
                <dd><a href="/about/index.html#contract" onclick="_hmt.push(['_trackEvent', '官网', 'click', '底部菜单_本层_底部_文字链_联系我们'])">联系我们</a></dd>
                <dd><a href="https://app.mokahr.com/apply/ucpaas" onclick="_hmt.push(['_trackEvent', '官网', 'click', '底部菜单_本层_底部_文字链_加入我们'])">加入我们</a></dd>
            </dl>
            <dl>
                <dt>产品</dt>
                <dd><a href="/product/sms.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '底部菜单_本层_底部_文字链_短信验证码'])">短信验证</a></dd>
                <dd><a href="/product/voice-code.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '底部菜单_本层_底部_文字链_语音验证码'])">语音验证</a></dd>
                <dd><a href="/product/message-notice.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '底部菜单_本层_底部_文字链_短信通知'])">短信通知</a></dd>
                <dd><a href="/product/voice-notice.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '底部菜单_本层_底部_文字链_语音通知'])">语音通知</a></dd>
                <dd><a href="/product/hidden-call.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '底部菜单_本层_底部_文字链_隐号通话'])">隐私保护通话</a></dd>
                <dd><a href="/product/cloud-service.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '底部菜单_本层_底部_文字链_云客服API'])">呼叫中心</a></dd>
            </dl>
            <dl>
                <dt>客户案例</dt>
                <dd><a href="/case/lianjia.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '底部菜单_本层_底部_文字链_链家网'])">链家网</a></dd>
                <dd><a href="/case/gionee.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '底部菜单_本层_底部_文字链_金立手机'])">金立手机</a></dd>
                <dd><a href="/case/jindie.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '底部菜单_本层_底部_文字链_云之家'])">云之家</a></dd>
                <dd><a href="/case/index.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '底部菜单_本层_底部_文字链_客户案例'])">更多案例</a></dd>
            </dl>
            <dl>
                <dt>开发者服务</dt>
                <dd><a href="http://docs.ucpaas.com/doku.php" onclick="_hmt.push(['_trackEvent', '官网', 'click', '底部菜单_本层_底部_文字链_开发文档'])">开发文档</a></dd>
                <dd><a href="/product/sdk-download.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '底部菜单_本层_底部_文字链_SDK下载'])">SDK下载</a></dd>
                <dd><a href="/mt/FAQ/index.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '底部菜单_本层_底部_文字链_常见问题'])">常见问题</a></dd>
                <dd><a href="/about/items.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '底部菜单_本层_底部_文字链_用户协议'])">用户协议</a></dd>
            </dl>
            <dl class="share">
                <dt>关注云提醒</dt>
                <dd>
                    <img src="/pages/images/wx_code.png" />
                    <span>云提醒官方微信</span>
                </dd>
            </dl>
        </div>
        <div class="relate_links">
            <div class="relate_wp">
                <span  target="_blank">友情链接</span><i class="first"></i>
                <?php
                use common\models\FriendlyLink;

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
                    <span class="icp"><a href="http://www.miitbeian.gov.cn/"  target="_blank">京ICP备14046848号</a></span>
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