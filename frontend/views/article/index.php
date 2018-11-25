<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-03-15 21:16
 */

/**
 * @var $this yii\web\View
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $type string
 */

use common\models\Options;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\widgets\ArticleListView;
use frontend\controllers\components\Article;
use frontend\widgets\ScrollPicView;
use common\widgets\JsBlock;
use frontend\assets\IndexAsset;
use yii\helpers\StringHelper;
use yii\widgets\LinkPager;

$this->title = yii::$app->feehi->website_title;

$this->registerMetaTag(['keywords' => yii::$app->feehi->seo_keywords]);
$this->registerMetaTag(['description' => yii::$app->feehi->seo_description]);
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

    <div class="item_box media-box1">
        <div class="item_box_wp">
            <ul class="media-list">
                <?php
                if($list){
                    foreach ($list as $item) {
                        echo '<li class="clearfix"><div class="detail">
                        <p class="tit"><a href="'.Url::to(['article/view', 'id' => $item->id]).'" ><b>'.$item->title.'</b></a>
                        <span class="date">'.date('Y-m-d', $item->created_at).'</span></p>
                        <p class="txt">'.$item->summary.'</p>
                        <p class="more"><a href="'.Url::to(['article/view', 'id' => $item->id]).'">阅读全文</a></p>
                    </div>
                </li>';
                    }
                }?>
            </ul>
            <div class="pagenum">
                <?=LinkPager::widget([
                    'pagination' => $pagination,
                ]);?>
            </div>
        </div>
    </div>
</div>
<!--主体部分 ft_content eof-->

<?=$this->render('/pages/footer');?>
</body>
</html>
