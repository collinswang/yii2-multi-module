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
                <?php
                $count = count($flash);
                $nav = '';
                foreach ($flash as $key => $item) {
                    if ($key == 0) {
                        $style = 'swiper-slide-duplicate-active';
                    } elseif ($key == 1) {
                        $style = 'swiper-slide-duplicate-next';
                    } elseif ($key == $count - 1) {
                        $style = 'swiper-slide-prev';
                    }
                    echo '<li class="swiper-slide" style="background: url('.$item['img'].') no-repeat center center;"></li>';
                    $nav .='<a href="javascript:void(0)" class="js-go-banner '.($key==0? 'cur':'').'" data-page="'.$key.'"></a>';
                } ?>
            </ul>
            <div class="circle_btns" id="circle_btns">
                <?=$nav;?>
            </div>
        </div>
    </div>
    <div class="idx_box_wp">
        <div class="wraper">
            <h2>云提醒 · 短信</h2>
            <ul class="topic">
                <li class="li1">
                    <dt>
                        <img src="/pages/images/msg-notice-p2.png" alt="稳定快速" draggable="false">
                    </dt>
                    <dd>
                        <b>稳定快速</b>
                    </dd>
                    <dd>高速短信通道，最高可达1000条/秒，短信发送最快3秒到达</dd>
                </li>
                <li class="li2">
                    <dt>
                        <img src="/pages/images/msg-notice-p3.png" alt="满足个性化" draggable="false">
                    </dt>
                    <dd>
                        <b>满足个性化</b>
                    </dd>
                    <dd>支持自定义签名， 支持为不同的客户提供独享通道、专用通道、大客户通道</dd>
                </li>
                <li class="li3">
                    <dt>
                        <img src="/pages/images/msg-notice-p5.png" alt="实时监测" draggable="false">
                    </dt>
                    <dd>
                        <b>实时监测</b>
                    </dd>
                    <dd>系统采用自动报警机制，随时随地监测短信发送与接收情况</dd>
                </li>
                <li class="li4">
                    <dt>
                        <img src="/pages/images/msg-notice-p6.png" alt="主备通道" draggable="false">
                    </dt>
                    <dd>
                        <b>主备通道</b>
                    </dd>
                    <dd>多点部署，主备通道规避突发风险。系统即时监测用户实时下发量，超前备份两倍处理能力，确保发送不堵车</dd>
                </li>
            </ul>
        </div>
    </div>

    <div class="idx_box_wp index-business">
        <div class="wraper" style="padding-bottom: 20px;">
            <h2>云通信 · 让业务迅速起航</h2>
            <div class="flexslider">
                <ul class="slides clearfix">
                    <li class="bs-con clearfix">
                        <div class="bs-l">
                            <div class="title">
                                <img src="/pages/images/index-bus-icon1.png" />
                                <h3>物流提醒</h3>
                                <p>买家下单后，告知商品的物流状态，发货快递单号，请买家注意查收。物流提醒助力提升店铺服务质量，安抚客户，使客户放心。</p>
                                <p class="second">使用场景：新用户注册、用户身份认证</p>
                            </div>
                            <ul>
                                <li>
                                    <a href="#">了解更多</a>
                                </li>
                            </ul>
                        </div>
                        <div class="bs-r">
                            <img src="/pages/images/sms-notice-scene1.png" />
                        </div>
                    </li>
                    <li class="bs-con clearfix" style="display: none;">
                        <div class="bs-l">
                            <div class="title">
                                <img src="/pages/images/index-bus-icon2.png" alt="注册及验证" />
                                <h3>会员服务</h3>
                                <p>会员服务短信提醒，节假日专属活动通知，活动推广等。</p>
                                <p class="second">适用场景：活动运营推广，用户维系</p>
                            </div>
                            <ul>
                                <li>
                                    <a href="#">了解更多</a>
                                </li>
                            </ul>
                        </div>
                        <div class="bs-r">
                            <img src="/pages/images/sms-notice-scene2.png" />
                        </div>
                    </li>
                    <li class="bs-con clearfix" style="display: none;">
                        <div class="bs-l">
                            <div class="title">
                                <img src="/pages/images/index-bus-icon3.png" alt="注册及验证" />
                                <h3>订票</h3>
                                <p>在客户购票后，下发提醒短信，票务信息一手掌握。</p>
                                <p class="second">适用场景：旅游,民宿,赛事</p>
                            </div>
                            <ul>
                                <li>
                                    <a href="#">了解更多</a>
                                </li>
                            </ul>
                        </div>
                        <div class="bs-r">
                            <img src="/pages/images/sms-notice-scene3.png" />
                        </div>
                    </li>
                    <li class="bs-con clearfix" style="display: none;">
                        <div class="bs-l">
                            <div class="title">
                                <img src="/pages/images/index-bus-icon4.png" alt="注册及验证" />
                                <h3>重大事件通知</h3>
                                <p>在社会生活和设备平台维护工作中，如果发生突发的重大安全事件或者设备故障告警，语音通知平台可以7*24小时全天候地将告警信息第一时间通知到相关处理人员，确保重大事件和故障得到及时响应。</p>
                                <p class="second">适用场景：突发事件,危机公关</p>
                            </div>
                            <ul>
                                <li>
                                    <a href="#">了解更多</a>
                                </li>
                            </ul>
                        </div>
                        <div class="bs-r">
                            <img src="/pages/images/sms-notice-scene4.png" />
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

    <div class="idx_box_wp index-btn">
        <div class="wraper">
            <h2>现在注册，开启便捷生活</h2>
            <div class="btn"><a href="<?=Url::toRoute(['/site/reg'])?>" class="green-btn">免费注册</a></div>
        </div>
    </div>
</div>

<?=$this->render('footer');?>

</body>
</html>
