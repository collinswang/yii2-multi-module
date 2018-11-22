<?php
/**
 *
 * User: collins
 * Date: 18-11-13
 */

use yii\helpers\Url;
use \yii\helpers\Html;

$this->params['breadcrumbs'][] = 'Index';
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
    <link rel='stylesheet' type='text/css' href='/pages/css/index.css'/>
    <script type="text/javascript" src="/pages/js/jquery-1.12.3.min.js"></script>
    <!--[if lte IE 8]>
    <link rel='stylesheet' type='text/css' href='/pages/css/ie8.css'/>

    <![endif]-->
    <!--公共头部 ft_header bof-->
</head>

<body id="b-01" data-nav="home" class="index_validate">
<?=$this->render('header');?>

<!--主体部分 ft_content bof-->
<input  type="hidden" value="1" id="if-index">
<div class="ft_content index">

    <div class="ft_banner banner_box" id="banner_box" style="margin-top: 60px">
        <div class="banner swiper-container">
            <ul class="banner_list  swiper-wrapper dis-n" id="banner_list">
                <li class="swiper-slide banner-item-AI">
                    <a href="http://xiaoyun.ucpaas.com/" target="_blank" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_banner_按钮_短信促销活动页面'])"><span></span></a>
                </li>

                <li class="swiper-slide banner-item-1">
                    <div class="banner-con banner1-con">
                        <div class="bm_txt">
                            <strong>全能力融合通信开放平台</strong>
                            <p class="link"><a href="/user/toSign" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_banner_按钮_注册按钮'])">免费注册</a></p>
                        </div>
                        <div class="banner1-img">
                            <div class="point-msg js-point-msg  msg1" data-show-index="0">
                                <p><a class="banner-1-a" href="/product/sms.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_banner_文字链_短信验证码'])">短信</a></p>
                                <div class="bg">
                                    <img src="/pages/images/banner-flash-img1.png" class="first js-flash-img" data-width="38" data-delay="0"/>
                                    <img src="/pages/images/banner-circle-img1.png"  class="second"/>
                                </div>
                            </div>
                            <div class="point-msg js-point-msg  msg2" data-show-index="0">
                                <p><a class="banner-1-a" href="/product/voice-code.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_banner_文字链_语音验证码'])">语音</a></p>
                                <div class="bg">
                                    <img src="/pages/images/banner-flash-img2.png" class="first js-flash-img" data-width="29" data-delay="500"/>
                                    <img src="/pages/images/banner-circle-img2.png"  class="second"/>
                                </div>
                            </div>
                            <div class="point-msg js-point-msg  msg3" data-show-index="1">
                                <p><a class="banner-1-a" href="/product/hidden-call.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_banner_文字链_隐号通话'])">隐私通话</a></p>
                                <div class="bg">
                                    <img src="/images/banner-flash-img3.png" class="first js-flash-img" data-width="31" data-delay="1000"/>
                                    <img src="/images/banner-circle-img3.png"  class="second"/>
                                </div>
                            </div>
                            <div class="point-msg js-point-msg  msg4" data-show-index="1">
                                <p><a class="banner-1-a" href="/product/traffic.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_banner_文字链_流量包'])">u+企业通信</a></p>
                                <div class="bg">
                                    <img src="/images/banner-flash-img4.png" class="first js-flash-img" data-width="30" data-delay="1500"/>
                                    <img src="/images/banner-circle-img4.png"  class="second"/>
                                </div>
                            </div>
                            <div class="point-msg js-point-msg  msg5" data-show-index="0">
                                <p><a class="banner-1-a" href="/product/cloud-service.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_banner_文字链_云客服API'])">云客宝</a></p>
                                <div class="bg">
                                    <img src="/images/banner-flash-img5.png" class="first js-flash-img" data-width="27" data-delay="2000"/>
                                    <img src="/images/banner-circle-img5.png"  class="second"/>
                                </div>
                            </div>
                            <div class="point-msg js-point-msg  msg7" data-show-index="1">
                                <p><a class="banner-1-a" href="/product/net-voice.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_banner_文字链_互联网语音通话'])">语音通话</a></p>
                                <div class="bg">
                                    <img src="/images/banner-flash-img7.png" class="first js-flash-img" data-width="29" data-delay="2500"/>
                                    <img src="/images/banner-circle-img7.png"  class="second"/>
                                </div>
                            </div>
                            <div class="point-msg js-point-msg  msg8" data-show-index="1">
                                <p><a class="banner-1-a" href="/product/net-video.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_banner_文字链_互联网视频通话'])">视频通话</a></p>
                                <div class="bg">
                                    <img src="/images/banner-flash-img8.png" class="first js-flash-img" data-width="31" data-delay="3000"/>
                                    <img src="/images/banner-circle-img8.png"  class="second"/>
                                </div>
                            </div>
                            <div class="point-msg js-point-msg  msg9" data-show-index="0">
                                <p><a class="banner-1-a" href="/product/net-video.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_banner_文字链_互联网视频通话'])">小云AI</a></p>
                                <div class="bg">
                                    <img src="/images/banner-flash-img5.png" class="first js-flash-img"  data-width="31" data-delay="3500"/>
                                    <img src="/images/banner-circle-img5.png"  class="second"/>
                                </div>
                            </div>
                            <div class="point-msg js-point-msg  msg10" data-show-index="1">
                                <p><a class="banner-1-a" href="/product/net-video.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_banner_文字链_互联网视频通话'])">流量</a></p>
                                <div class="bg">
                                    <img src="/images/banner-flash-img8.png" class="first js-flash-img"  data-width="31" data-delay="4000"/>
                                    <img src="/images/banner-circle-img8.png"  class="second"/>
                                </div>
                            </div>
                            <div class="point-msg js-point-msg  msg11" data-show-index="1">
                                <p><a class="banner-1-a" href="/product/net-video.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_banner_文字链_互联网视频通话'])">呼叫中心</a></p>
                                <div class="bg">
                                    <img src="/images/banner-flash-img3.png" class="first js-flash-img" data-width="30"  data-delay="4500"/>
                                    <img src="/images/banner-circle-img3.png"  class="second"/>
                                </div>
                            </div>


                        </div>
                    </div>
                </li>
                <li class="swiper-slide banner_tiem_index">
                    <a href="/news/201708228.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_banner_按钮_发布会见证'])"><span class="btn_submit"></span></a>
                </li>
                <li class="swiper-slide banner-item-Traffic">
                    <a href="/product/internetTraffic.html">  </a>

                </li>
            </ul>
            <div class="circle_btns" id="circle_btns">
                <a href="javascript:void(0)" class="js-go-banner cur" data-page="0"></a>
                <a href="javascript:void(0)" class="js-go-banner " data-page="1"></a>
                <a href="javascript:void(0)" class="js-go-banner " data-page="2"></a>
                <a href="javascript:void(0)" class="js-go-banner " data-page="3"></a>
            </div>
        </div>
    </div>

    <div class="idx_box_wp index-adv-content">
        <ul class="wraper">
            <li class="item first">
                <div>
                    <a href="/about/index.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_首页banner下_按钮_关于我们'])">
                        <h6>选择云提醒</span></h6>
                        <p>全面了解云提醒</p>
                    </a>
                </div>
            </li>
            <li class="item second">
                <div>
                    <a href="/service/sms.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_首页banner下_按钮_短信验证码'])">
                        <h6>短信大优惠</h6>
                        <p>充值越多越便宜</p>
                    </a>
                </div>
            </li>
            <li class="item third">
                <div>
                    <a href="/news/201804262.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_首页banner下_按钮_新闻动态'])">
                        <h6>新闻动态</h6>
                        <p >云提醒物联网解决方案出炉</p>
                    </a>

                </div>
            </li>
            <li class="item forth">
                <div>
                    <a href="/about/event.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_首页banner下_按钮_大事记'])">
                        <h6>大事记</h6>
                        <p>云提醒发展历程</p>
                    </a>
                </div>
            </li>
        </ul>
    </div>

    <div class="idx_box_wp index-product">
        <div class="wraper">
            <h2>稳定、全面的通讯产品</h2>
            <div class="pro-content">
                <ul class="clearfix first-ul">
                    <li class="pro-list pro-list1 active js-pro-list">
                        <div class="con-card">
                            <div class="card-t">
                                <span class="icon"></span>
                                <h3>身份验证</h3>
                                <p>5秒必达、99%到达率</p>
                            </div>
                            <div class="card-about">
                                <div class="off">
                                    <ul>
                                        <li>短信验证</li>
                                        <li>语音验证</li>
                                    </ul>
                                </div>
                                <div class="on">
                                    <div class="first">
                                        <h4>短信验证</h4>
                                        <p>自主开发的分发系统，监控质量，99%到达率。优惠促销低至<span class="color-y">0.036</span>元/条</p>
                                        <a href="/product/sms.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_首页中部产品栏目_按钮_短信验证码'])" style="width: 130px;">接入即享超值优惠</a>
                                    </div>
                                    <div class="other">
                                        <ul class="clearfix">
                                            <li>
                                                <h4>语音验证</h4>
                                                <p>自主开发的分发系统，监控质量，99%到达率。</p>
                                                <a href="/product/voice-code.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_首页中部产品栏目_按钮_语音验证码'])">立即接入</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="pro-list pro-list2 js-pro-list">
                        <div class="con-card">
                            <div class="card-t">
                                <span class="icon"></span>
                                <h3>消息推送</h3>
                                <p>轻松接入无遗漏烦忧</p>
                            </div>
                            <div class="card-about">
                                <div class="off">
                                    <ul>
                                        <li>短信通知
                                        </li>
                                        <li>会员短信
                                        </li>
                                        <li>国际短信
                                        </li>
                                        <li>语音通知
                                        </li>
                                        <li>ESMS
                                        </li>
                                    </ul>
                                </div>
                                <div class="on">
                                    <div class="first">
                                        <h4>短信通知</h4>
                                        <p>无盲点覆盖三网，准时及时</p>
                                        <a href="/product/message-notice.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_首页中部产品栏目_按钮_短信通知'])">立即接入</a>
                                    </div>
                                    <div class="other">
                                        <ul class="clearfix">
                                            <li>
                                                <h4>会员短信</h4>
                                                <p>用户激活，促销，满减，快速便捷触达用户</p>
                                                <a href="product/sms-market.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_首页中部产品栏目_按钮_会员服务'])">立即接入</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="other">
                                        <ul class="clearfix">
                                            <li>
                                                <h4>国际短信</h4>
                                                <p>海外APP、网站、微信公众号开发者/跨境电商、跨境物流</p>
                                                <a href="product/international-verification-code.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_首页中部产品栏目_按钮_国际短信'])">立即接入</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="other">
                                        <ul class="clearfix">
                                            <li>
                                                <h4>语音通知</h4>
                                                <p>简单、轻松接入，100%收到，无遗漏烦忧</p>
                                                <a href="/product/voice-notice.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_首页中部产品栏目_按钮_语音通知'])">立即接入</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="other">
                                        <ul class="clearfix">
                                            <li>
                                                <h4>ESMS</h4>
                                                <p>实时、高效、稳定、安全，私有化部署，支持定制化</p>
                                                <a href="/product/esms.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_首页中部产品栏目_按钮_语音通知'])">立即接入</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="pro-list pro-list3 js-pro-list">
                        <div class="con-card">
                            <div class="card-t">
                                <span class="icon"></span>
                                <h3>呼叫中心</h3>
                                <p>低门槛、跨区域、无时限</p>
                            </div>
                            <div class="card-about">
                                <div class="off">
                                    <ul>
                                        <li>
                                            隐私保护通话
                                        </li>
                                        <li>
                                            呼叫中心
                                        </li>
                                        <li>
                                            云客宝
                                        </li>
                                        <li>
                                            小云AI
                                        </li>
                                    </ul>
                                </div>
                                <div class="on">
                                    <div class="first">
                                        <h4>隐私保护通话</h4>
                                        <p>双向保护、防止骚扰、录音清晰、快速接入</p>
                                        <a href="/product/hidden-call.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_首页中部产品栏目_按钮_隐私保护通话'])">查看详情</a>
                                    </div>
                                    <div class="other">
                                        <ul class="clearfix">
                                            <li>
                                                <h4>呼叫中心</h4>
                                                <p>零成本、零插件、低门槛、跨区域、无时限，客服服务平台</p>
                                                <a href="/product/cloud-service.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_首页中部产品栏目_按钮_客服API'])">查看详情</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="other">
                                        <ul class="clearfix">
                                            <li>
                                                <h4>云客宝</h4>
                                                <p>信息度高、支持定制、智能客服、快速接入</p>
                                                <a href="/product/cloud-guest-treasure.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_首页中部产品栏目_按钮_客服API'])">查看详情</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="other">
                                        <ul class="clearfix">
                                            <li>
                                                <h4>小云AI</h4>
                                                <p>自主学习、精准识别、高效过滤、无缝对接</p>
                                                <a href="http://xiaoyun.ucpaas.com/" target="_blank" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_首页中部产品栏目_按钮_客服API'])">查看详情</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="pro-list js-pro-list">
                        <div class="con-card">
                            <div class="card-t">
                                <span class="icon"></span>
                                <h3>互联网通信</h3>
                                <p>亿级、3A音频、QOS视频</p>
                            </div>
                            <div class="card-about">
                                <div class="off">
                                    <ul>
                                        <li>
                                            音视频
                                        </li>
                                        <li>
                                            U+企业通信
                                        </li>
                                        <li>
                                            云视频会议
                                        </li>
                                        <li>
                                            牵牛快信
                                        </li>
                                    </ul>
                                </div>
                                <div class="on">
                                    <div class="first">
                                        <h4>音视频</h4>
                                        <p>专注于智能硬件视频通话，先进的QOS算法，不掉线、低延迟</p>
                                        <a href="/product/video.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_首页中部产品栏目_按钮_互联网音视频通话'])">查看详情</a>
                                    </div>
                                    <div class="other">
                                        <ul class="clearfix">
                                            <li>
                                                <h4>U+企业通信</h4>
                                                <p>统一通讯录，即时沟通，智能办公电话，随时随地发起会议</p>
                                                <a href="/product/u-communication.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_首页中部产品栏目_按钮_客服API'])">查看详情</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="other">
                                        <ul class="clearfix">
                                            <li>
                                                <h4>云视频会议</h4>
                                                <p>基于云计算的大型网络视频会议系统，海量并发，灵活定制</p>
                                                <a href="/product/cloud-video.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_首页中部产品栏目_按钮_客服API'])">查看详情</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="other">
                                        <ul class="clearfix">
                                            <li>
                                                <h4>牵牛快信</h4>
                                                <p>快递、物流、旅游等领域专业通讯解决方案</p>
                                                <a href="/product/lead-cow.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_首页中部产品栏目_按钮_客服API'])">查看详情</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="pro-list pro-list6 js-pro-list">
                        <div class="con-card">
                            <div class="card-t">
                                <span class="icon"></span>
                                <h3>流量</h3>
                                <p>三网、易接入</p>
                            </div>
                            <div class="card-about">
                                <div class="off">
                                    <ul>
                                        <li>
                                            MIFI
                                        </li>
                                        <li>
                                            流量包
                                        </li>
                                        <li>
                                            物联网流量卡
                                        </li>
                                    </ul>
                                </div>
                                <div class="on">
                                    <div class="first">
                                        <h4>MIFI</h4>
                                        <p>无需插卡、智能匹配最优网络、零漫游、随时随地WiFi自由上网 </p>
                                        <a href="/product/mifi.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_首页中部产品栏目_按钮_mifi'])">查看详情</a>
                                    </div>
                                    <div class="other">
                                        <ul class="clearfix">
                                            <li>
                                                <h4>流量包</h4>
                                                <p>融合电信、移动、联通三网全国以及省份流量，助力企业营销</p>
                                                <a href="/product/traffic.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_首页中部产品栏目_按钮_流量包'])">查看详情</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="other">
                                        <ul class="clearfix">
                                            <li>
                                                <h4>物联网流量卡</h4>
                                                <p>三网流量、灵活套餐、优势资费、全国通用</p>
                                                <a href="/product/internetTraffic.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_首页中部产品栏目_按钮_物联网流量卡'])">查看详情</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="pro-bg">
                <img class="bg-l" src="/pages/images/index-l-icon.png" alt="背景" />
                <img class="bg-r" src="/pages/images/index-r-icon.png" alt="背景" />
            </div>
        </div>
    </div>

    <div class="idx_box_wp index-business">
        <div class="wraper">
            <h2>云通信 · 让业务迅速起航</h2>
            <div class="flexslider">
                <ul class="slides clearfix">
                    <li class="bs-con clearfix">
                        <div class="bs-l">
                            <div class="title">
                                <img src="/pages/images/index-bus-icon1.png" alt="注册及验证" />
                                <h3>注册及验证</h3>
                                <p>上网并发，及时、便捷、稳定</p>
                                <p class="second">使用场景：新用户注册、用户身份认证</p>
                            </div>
                            <ul>
                                <li>
                                    <h5>短信验证</h5>
                                    <p>最快3秒到达、15分钟快速接入、低至4分钱</p>
                                    <a href="/product/sms.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_中部_按钮_短信验证码'])">了解更多</a>
                                </li>
                                <li>
                                    <h5>语音验证</h5>
                                    <p>优质号段资源、杜绝恶性刷单、无高峰延迟</p>
                                    <a href="/product/voice-code.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_中部_按钮_语音验证码'])">了解更多</a>
                                </li>
                            </ul>
                        </div>
                        <div class="bs-r">
                            <img src="/pages/images/index-business1.png" />
                        </div>
                    </li>
                    <li class="bs-con clearfix" style="display: none;">
                        <div class="bs-l">
                            <div class="title">
                                <img src="/pages/images/index-bus-icon2.png" alt="注册及验证" />
                                <h3>推广及通知</h3>
                                <p>无遗漏、高并发、优质号段</p>
                                <p class="second">适用场景：活动运营推广，用户维系，订单通知，物流通知，重大事件通报</p>
                            </div>
                            <ul>
                                <li>
                                    <h5>短信通知</h5>
                                    <p>最快3秒到达、15分钟快速接入、低至4分钱</p>
                                    <a href="/product/message-notice.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_中部_按钮_短信通知'])">了解更多</a>
                                </li>
                                <li>
                                    <h5>语音通知</h5>
                                    <p>优质号段资源、杜绝恶性刷单、无高峰延迟</p>
                                    <a href="/product/voice-notice.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_中部_按钮_语音通知'])">了解更多</a>
                                </li>
                            </ul>
                        </div>
                        <div class="bs-r">
                            <img src="/pages/images/index-business2.png" />
                        </div>
                    </li>
                    <li class="bs-con bs-con3 clearfix" style="display: none;">
                        <div class="bs-l">
                            <div class="title">
                                <img src="/pages/images/index-bus-icon3.png" alt="注册及验证" />
                                <h3>号码保护</h3>
                                <p>双隐模式更安全，专属中间号快捷互通</p>
                                <p class="second">适用场景：临时性联络需求，如中介，网约车，O2O等</p>
                            </div>
                            <ul>
                                <li>
                                    <h5>隐私保护通话</h5>
                                    <p>保护用户隐私、提升满意度，工作资料防泄漏</p>
                                    <a href="/product/hidden-call.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_中部_按钮_隐私保护通话'])">了解更多</a>
                                </li>
                            </ul>
                        </div>
                        <div class="bs-r">
                            <img src="/pages/images/index-business3.png" />
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="idx_box_wp index-data js-index-data">
        <div class="wraper">
            <ul class="clearfix">
                <li>
                    <p><span class="js-num-grow-up"  data-target="230">0</span><sup>+</sup>国家与地区</p>
                </li>
                <li>
                    <p><span class="js-num-grow-up"  data-target="16">0</span>万<sup>+</sup>开发者</p>
                </li>
                <li>
                    <p><span class="js-num-grow-up"  data-target="2">0</span>亿<sup>+</sup>覆盖终端用户</p>
                </li>
            </ul>
        </div>
    </div>

    <div class="idx_box_wp index-partners">
        <div class="wraper">
            <h2>因为专业 · 所以信赖</h2>
            <div class="part-con">
                <img src="/pages/images/cmpy-bg2.png" alt="客户" width="1180">
            </div>
        </div>
    </div>

    <div class="idx_box_wp index-news">
        <div class="wraper">
            <h2>云提醒 · 新动态</h2>
            <div class="news-con">
                <ul>
                    <li>
                        <div class="title">
                            <a href="/news/201708228.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_底部_按钮_新闻动态'])">
                                <div class="t-img">
                                    <img src="/pages/images/8-1FQG011250-L.jpg" width='375.59px' height='176px' alt="云提醒完成B轮3亿融资，平台开放为产业链赋能" />
                                </div>
                                <h4>云提醒完成B轮3亿融资，平台开放为产业链赋能</h4>
                            </a>
                        </div>
                        <div class="news-list">
                            <a href="/news/201804262.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_底部_按钮_新闻动态'])">云提醒物联网解决方案出炉，关注场景和应用</a>
                            <a href="/news/201804261.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_底部_按钮_新闻动态'])">从心出发，跨越生长，云提醒四周年趣味运动会</a>

                        </div>
                    </li>

                    <li>
                        <div class="title">
                            <a href="/news/201804257.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_底部_按钮_新闻动态'])">
                                <div class="t-img">
                                    <img src="/pages/images/8-1P41GR35G32.png" width='375.59px' height='176px' alt="云提醒MiFi发布，你的流量你做主" />
                                </div>
                                <h4>云提醒MiFi发布，你的流量你做主</h4>
                            </a>
                        </div>
                        <div class="news-list">
                            <a href="/news/201804255.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_底部_按钮_新闻动态'])">变革：人工智能+全营销平台</a>
                            <a href="/news/201802253.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_底部_按钮_新闻动态'])">云提醒2018春节放假通知及服务安排</a>

                        </div>
                    </li>
                    <li class="item3">
                        <div class="title">
                            <a href="/news/201804261.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_底部_按钮_新闻动态'])">
                                <div class="t-img">
                                    <img src="/pages/images/8-1P41QH120308.jpg" width='375.59px' height='176px'  alt="云提醒完成B轮3亿融资，平台开放为产业链赋能" />
                                </div>
                                <h4>从心出发，跨越生长，云提醒四周年趣味运动会</h4>
                            </a>
                        </div>

                        <div class="news-list">
                            <!--<a href="/news/201804261.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_底部_按钮_新闻动态'])">你在愚人节玩整蛊，我们在阳光下为团队荣耀而战！</a>-->

                            <!--<a href="/mt/notice/20180202250.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_底部_按钮_新闻动态'])">【更新通知】云提醒3.0.2版本更新</a>-->
                            <a href="/mt/notice/20180209251.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_底部_按钮_新闻动态'])">【通知】春节期间我司客服业务正常运行</a>
                            <a href="/mt/notice/20180202250.html" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_底部_按钮_新闻动态'])">【更新通知】云提醒3.0.2版本更新</a>

                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="idx_box_wp index-btn">
        <div class="wraper">
            <h2>现在注册，即享新手专属礼包</h2>
            <div class="btn"><a href="/user/toSign" class="green-btn" onclick="_hmt.push(['_trackEvent', '官网', 'click', '首页_本层_中部_按钮_注册按钮'])">免费注册</a></div>
        </div>
    </div>
</div>

<?=$this->render('footer');?>

</body>
</html>
