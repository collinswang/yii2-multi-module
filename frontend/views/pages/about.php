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
    <link rel='stylesheet' type='text/css' href='/pages/css/about.css'/>
    <script type="text/javascript" src="/pages/js/jquery-1.12.3.min.js"></script>
    <!--[if lte IE 8]>
    <link rel='stylesheet' type='text/css' href='/pages/css/ie8.css'/>

    <![endif]-->
    <!--公共头部 ft_header bof-->
</head>

<body id="b-01" data-nav="home" class="index_validate">
<?=$this->render('header');?>
<!--主体部分 ft_content bof-->
<div class="cul_content">
    <div class="cul_banner" style="background-image: none;">
        <div class="cul_banner_wp">
            <div class="txt">
                <h1>云提醒·让通讯更简单</h1>
                <h2>--专注于提供短信服务--</h2>
            </div>
        </div>
    </div>

    <div class="item_box about-box1">
        <div class="item_box_wp">
            <div class="title">
                <h4>简介·云提醒</h4>
            </div>
            <div class="con">
                <p>
                    云提醒专业提供针对小微企业,商家,微商等提供短信群发服务的通信平台，提供包括各类通知/营销短信解决方案，利用大数据、人工智能等高新技术帮助企业客户解决营销、生产、
                    协同等场景的通信需求，实现人与人，人与物，物与物的高效连接。
                </p>
            </div>
            <div class="bg"><img src="/pages/images/cmpy-bg1.png"></div>
        </div>
    </div>

    <div class="item_box about-box2" style="background-size: cover">
        <div class="item_box_wp">
            <div class="title" style=" text-align: center;padding-top: 300px;">
                <h4>观察·云提醒</h4>
                <p>融合通讯提供商，接口简单，提升通讯</p>
            </div>
        </div>
    </div>

    <div class="item_box about-box3">
        <div class="item_box_wp">
            <div class="num_list">
                <img src="/pages/images/cmpy-data-new.png" alt="数字云提醒">
            </div>
        </div>
    </div>

    <div class="item_map" id="contract">
        <div class="item_map_w">
            <h2 class="map_title">联系我们</h2>
            <ul id="mapImgList" class="map_img_list">
                <li style="display: block;">
                    <img class="map_img" src="/pages/images/map_sz.png" alt="">
                    <div class="map_item sz_position">
                        <h4 class="user_name">北京世恒绿都科技有限公司</h4>
                        <p class="map_desc">地址：北京市房山区长阳万兴路86号F-102</p>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="item_box btn-box">
        <div class="item_box_wp">
            <h2>现在注册，即享新手专属礼包</h2>
            <div class="btn"><a href="<?=Url::toRoute(['/site/reg'])?>" class="green-btn">免费注册</a>
            </div>
        </div>
    </div>

</div>
<!--主体部分 ft_content eof-->

<?=$this->render('footer');?>
</body>
</html>
