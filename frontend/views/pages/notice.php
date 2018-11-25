<?php
/**
 *
 * User: collins
 * Date: 18-11-13
 */
use yii\helpers\Url;

$this->params['breadcrumbs'][] = 'Pages';
?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
    <meta charset="UTF-8">
    <meta content="短信接口,pass平台,saas软件,流量充值,短信发送平台,im云,即时通讯云,云提醒,云通讯,云通信,SDK,API,视频会议,VTM,融合通信,政企通讯,视频云,视频直播,视频点播,视频会议,云呼叫中心,云客服,呼叫中心建设,呼叫中心能力,通讯线路,虚拟运营商,短信服务,流量分发平台,匿名通话,公费电话,企业服务,云提醒云通讯,隐私保护通话,云总机,身份认证,消息通知,在线客服,企业通信,企业协同通讯" name="keywords">
    <meta content="云提醒——精于技术，简于接口。云提醒PaaS平台将复杂的底层通讯资源打包成简单的API和SDK，让SaaS厂商和软件开发者可以方便的通过接口嵌入消息、语音、视频、流量、直播、身份验证等，从而实现云通讯的功能。云提醒提供的通信接口包括短信、隐私保护通话、多方通话、400电话、呼叫中心、隐私保护通话、云总机、身份认证、消息通知、IM（即时消息）、在线客服及企业通信等，广泛应用于O2O、电商、社交、生活服务、房地产、快递物流、交通出行、企业通信、智能硬件、移动医疗等行业。" name="description">
    <title>云提醒云通信平台_提供点击通话、短信验证码、语音验证码、视频、云呼叫中心、云总机、隐私保护通话、流量分发系统等服务的融合通讯开放平台</title>
    <!--[if IE 8 ]> <link rel='stylesheet' type='text/css' href='/pages/css/ie8.css'/> <![endif]-->
    <meta name="robots" content="index,follow"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <!--公共头部 ft_header bof-->
    <link rel="shortcut icon" href="/pages/images/ucpaas.ico" type="image/x-icon"/>
    <link rel='stylesheet' type='text/css' href='/pages/css/idangerous.swiper.css'/>
    <link rel='stylesheet' type='text/css' href='/pages/css/flexslider/css/flexslider.css'/>
    <link rel='stylesheet' type='text/css' href='/pages/css/base.css'/>
    <link rel='stylesheet' type='text/css' href='/pages/css/product.css'/>
    <script type="text/javascript" src="/pages/js/jquery-1.12.3.min.js"></script>
    <!--[if lte IE 8]>
    <link rel='stylesheet' type='text/css' href='/pages/css/ie8.css'/>

    <![endif]-->
    <!--公共头部 ft_header bof-->
</head>

<body id="b-01" data-nav="home" class="index_validate">
<?=$this->render('header');?>
<!--主体部分 ft_content bof-->
<div class="ft_content sms-market product_con">
    <div class="banner_box">
        <ul class="banner_list swiper-wrapper" id="banner_list">
            <li>
                <div class="ft_banner ft_banner_style">
                    <div class="ft_banner_wp clearfix">
                        <div class="banner_txt">
                            <h1>会员服务短信</h1>
                            <p class="features">用户激活，促销，满减<br>快速便捷触达用户</p>
                            <p class="link">
                                <a class="in" href="<?=Url::toRoute(['/site/reg'])?>">立即接入</a>
                                <!-- <a class="exp" href="/experience">在线体验</a> -->
                            </p>
                        </div>
                        <div class="banner_img">
                            <img src="/pages/images/market-banner-img.png" alt="会员服务短信">
                        </div>
                    </div>
                </div>
            </li>

        </ul>
    </div>

    <div class="item_box msg-box8" id="item_box1">
        <div class="item_box_wp">
            <div class="title">
                <h3 data-nav="price">产品简介</h3>
            </div>
            <div class="con">
                <p>安全、稳定的会员服务短信发送平台，为企业、店铺打造快速便捷的运营服务新通道，广泛用于促销、满减、折扣等服务类信息发布。</p>
            </div>
        </div>
    </div>

    <div class="item_box msg-box9" id="item_box2">
        <div class="item_box_wp">
            <div class="title">
                <h3 data-nav="price">应用场景</h3>
            </div>
            <div class="con clearfix">
                <ul>
                    <li data-tab="li1" class="js-pro-showHide"><a class="" href="javascript:void(0);" data-cl-id="766474322">会员激活</a></li>
                    <li data-tab="li2" class="js-pro-showHide"><a href="javascript:void(0);" data-cl-id="1435305311" class="active">渠道促销</a></li>
                    <li data-tab="li3" class="js-pro-showHide"><a href="javascript:void(0);" data-cl-id="2524245227">关注有礼</a></li>
                    <li data-tab="li4" class="js-pro-showHide"><a href="javascript:void(0);" class="last" data-cl-id="1396390029">新品上线</a></li>
                </ul>
                <div class="con_r clearfix">
                    <div id="li1" style="display: none;">
                        <div class="img"><img src="/pages/images/sms-market-scene1.png" alt="用户注册场景"></div>
                        <div class="txt">
                            <h3>会员激活</h3>
                            <p>会员在节假日会员活动通知，优惠折扣信息，活动推广等。能够帮助企业增加活跃客户数，提升销售机会和转化率。</p>
                            <a href="http://www.ucpaas.com/user/toSign?from=smsMarket" class="style-bg-w" onclick="_hmt.push(['_trackEvent', '官网', 'click', '产品页_会员服务短信_应用场景1_按钮_立即接入'])" data-cl-id="17086413">立即接入</a>
                        </div>
                    </div>
                    <div id="li2" class="hide" style="display: block;">
                        <div class="img"><img src="/pages/images/sms-market-scene2.png" alt="支付认证场景"></div>
                        <div class="txt">
                            <h3>渠道促销</h3>
                            <p>针对新用户、专属渠道执行的优惠、满减、打折活动，可通过短信方式直达潜在客户手机端，有利于形成第一时间的新客户注册、消费、成交等。</p>
                            <a href="http://www.ucpaas.com/user/toSign?from=smsMarket" class="style-bg-w" onclick="_hmt.push(['_trackEvent', '官网', 'click', '产品页_会员服务短信_应用场景2_按钮_立即接入'])" data-cl-id="17086413">立即接入</a>
                        </div>
                    </div>
                    <div id="li3" class="hide" style="display: none;">
                        <div class="img"><img src="/pages/images/sms-market-scene3.png" alt="账号认证场景"></div>
                        <div class="txt">
                            <h3>关注有礼</h3>
                            <p>企业自媒体需要增加粉丝时，可以利用关注有礼、新人专属礼包等模式融入短信中，吸引新客户收藏店铺、关注微博微信企业账号，为企业自媒体粉丝增长提供新渠道。</p>
                            <a href="http://www.ucpaas.com/user/toSign?from=smsMarket" class="style-bg-w" onclick="_hmt.push(['_trackEvent', '官网', 'click', '产品页_会员服务短信_应用场景3_按钮_立即接入'])" data-cl-id="17086413">立即接入</a>
                        </div>
                    </div>
                    <div id="li4" class="hide" style="display: none;">
                        <div class="img"><img src="/pages/images/sms-market-scene4.png" alt="找回密码场景"></div>
                        <div class="txt">
                            <h3>新品上线</h3>
                            <p>在企业新品上线期间，可以利用群发短信通知新老客户，以尝鲜、体验等模式获得第一手客户反馈，并逐渐赢得客户口碑。</p>
                            <a href="http://www.ucpaas.com/user/toSign?from=smsMarket" class="style-bg-w" onclick="_hmt.push(['_trackEvent', '官网', 'click', '产品页_会员服务短信_应用场景4_按钮_立即接入'])" data-cl-id="17086413">立即接入</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="item_box msg-box10" id="item_box3">
        <div class="item_box_wp">
            <div class="title">
                <h3 data-nav="price">产品优势</h3>
            </div>
            <div class="con">
                <div class="item_slide1  js-item-slide im slide-content">
                    <div class="flexslider">

                    </div>
                    <div class="flex-viewport" style="overflow: hidden; position: relative;"><ul class="slides" style="width: 800%; transition-duration: 0s; transform: translate3d(0px, 0px, 0px);">
                            <li class="li1" style="width: 242px; float: left; display: block;">
                                <dt>
                                    <img src="/pages/images/msg-market-p1.png" alt="稳定安全" draggable="false">
                                </dt>
                                <dd>
                                    <b>稳定安全</b>
                                </dd>
                                <dd>精挑细选稳定安全群发短信号段，优化屏蔽软件拦截，更高到达率</dd>
                            </li>
                            <li class="li5" style="width: 242px; float: left; display: block;">
                                <dt>
                                    <img src="/pages/images/msg-market-p2.png" alt="审核迅速" draggable="false">
                                </dt>
                                <dd>
                                    <b>审核迅速</b>
                                </dd>
                                <dd>专业团队7*24小时支持，让会员服务短信不错过任何时机</dd>
                            </li>
                            <li class="li6" style="width: 242px; float: left; display: block;">
                                <dt>
                                    <img src="/pages/images/msg-market-p3.png" alt="贴心服务" draggable="false">
                                </dt>
                                <dd>
                                    <b>贴心服务</b>
                                </dd>
                                <dd>支持自定义签名，支持记录详单，随时随地监测短信发送与接收情况</dd>
                            </li>
                            <li class="li3" style="width: 242px; float: left; display: block;">
                                <dt>
                                    <img src="/pages/images/msg-market-p4.png" alt="快速使用" draggable="false">
                                </dt>
                                <dd>
                                    <b>快速使用</b>
                                </dd>
                                <dd>支持群发/单发，即接即用，亦可通过对接API，无缝嵌入APP</dd>
                            </li>
                        </ul></div></div>
            </div>
        </div>
    </div>

    <div class="item_box msg-box7">
        <div class="item_box_wp">
            <h2>现在接入云提醒，让您的应用搭上云通讯快车</h2>
            <a href="<?=Url::toRoute(['/site/reg'])?>">立即接入</a>
        </div>
    </div>

</div>
<!--主体部分 ft_content eof-->
<script>
    //点击的时候显示或隐藏相应区域(tab)
    function showHidden(className,styleName) {
        $("body").on('click mouseover', '.' + className, function(event) {
            event.preventDefault();
            var target = $(this).attr("data-tab");
            var tt = $("#" + target);
            tt.show().siblings().hide();
            $(this).children('a').addClass(styleName).end().siblings().children('a').removeClass(styleName);
        });
    }

    $(function() {
        showHidden("js-pro-showHide","active");
        $(window).scroll(function(event) {
            var tar = $(".msg-nav");
            var scrollH = $(window).scrollTop();
            if (scrollH >= 560) {
                tar.addClass('fixed').find(".link_btn").show().siblings('.product_mark').show();
            } else {
                tar.removeClass('fixed').find(".link_btn").hide().siblings('.product_mark').hide();
            }
        });

    });
</script>

<!--主体部分 ft_content eof-->
<?=$this->render('footer');?>
</body>
</html>
