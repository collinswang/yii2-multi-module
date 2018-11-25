<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-04-02 22:55
 */

/**
 * @var $this yii\web\View
 * @var $model frontend\models\Article
 * @var $commentModel frontend\models\Comment
 * @var $prev frontend\models\Article
 * @var $next frontend\models\Article
 * @var $recommends array
 * @var $commentList array
 */

use yii\helpers\Url;
use frontend\assets\ViewAsset;
use common\widgets\JsBlock;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = $model->title;

$this->registerMetaTag(['keywords' => $model->seo_keywords]);
$this->registerMetaTag(['description' => $model->seo_description]);
$this->registerMetaTag(['tags' => call_user_func(function()use($model) {
    $tags = '';
    foreach ($model->articleTags as $tag) {
        $tags .= $tag->value . ',';
    }
    return rtrim($tags, ',');
    }
)]);
$this->registerMetaTag(['property' => 'article:author', 'content' => $model->author_name]);
$categoryName = $model->category ? $model->category->name : yii::t('app', 'uncategoried');

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
<?=$this->render('/pages/header');?>
<!--主体部分 ft_content bof-->
<div class="cul_content">
    <div class="cul_banner">
        <div class="cul_banner_wp">
            <div class="txt">
                <h1>云提醒·让通讯更简单</h1>
                <h2>--专注于提供短信服务--</h2>
            </div>
        </div>
    </div>

    <div class="item_box media-detail-box1">
        <div class="item_box_wp">
            <div class="new-con-l ft-l">
                <!-- <div class="place"> <strong>当前位置:</strong> <a href='//'>主页</a> > <a href='//mt/'>媒体报道</a> >  </div> -->
                <!-- /place -->
                <div class="news_detail">
                    <h6 class="art-title"><?=$model->title;?></h6>
                    <!--  <p class="date">2017-06-15 By 云吞吞 点击  <script src="//plus/count.php?view=yes&aid=220&mid=8" type='text/javascript' language="javascript"></script>次</p>   -->
                    <!-- /info -->
                    <div class="detail_left"><?=$model->articleContent->content;?></div>
                </div>
                <div class="detail_relate">
                    <?php if($prev){
                        echo '<span class="prev ft-l">上一篇：'.Html::a($prev->title, ['view', 'id'=>$prev->id]).'</span>';
                    }?>
                    <?php if($next){
                        echo '<span class="prev ft-l">下一篇：'.Html::a($next->title, ['view', 'id'=>$next->id]).'</span>';
                    }?>
                </div>
            </div>
            <div class="new-con-r ft-r">
                <div class="con  con1">
                    <h4>热门新闻</h4>
                        <ul>
                            <?php
                            if($recommends){
                                foreach ($recommends as $recommend) {
                                    echo '<li>'.Html::a($recommend->title, ['view', 'id'=>$recommend->id]).'</li>';
                                }
                            }
                            ?>
                        </ul>
                    </div>
            </div>
        </div>
    </div>
</div>
<!--主体部分 ft_content eof-->

<?=$this->render('/pages/footer');?>
</body>
</html>
