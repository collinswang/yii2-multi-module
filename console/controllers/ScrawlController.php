<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-05-18 11:13
 */
namespace console\controllers;


use common\components\Curl;
use common\modules\collect\data\CollectData;
use yii\console\Controller;

class ScrawlController extends Controller
{
    /**
     * 美团商家信息URL
     */
    const MEI_TUAN_URL = "https://apimobile.meituan.com/group/v1/poi/";

    /**
     * 饿了吗商家信息URL
     */
    const ELM_URL = "https://h5.ele.me/restapi//shopping/restaurant/";

    /**
     * TEST URL
     */
    const TEST_URL = "http://api.k2.com/?r=bbs/i_bbs_0677_v1/get-test";


    /**
     * php yii scrawl/index 100 10000
     * @param int $start
     * @param int $range
     */
    public function actionIndex($start = 100, $range = 100)
    {
        $end = $start + $range;
        for($i=$start; $i<$end; $i++){
            $this->actionCollectMeituan($i);
        }
    }

    /**
     * @param $id
     * php yii scrawl/collect-meituan 111
     */
    public function actionCollectMeituan($id)
    {
        $url = self::MEI_TUAN_URL.$id;
        $curl = new Curl(false);
        $result_json = true;
        $result = $curl->setUrl($url)->request($result_json);
        if(!isset($result['data']) || !isset($result['data'][0])){
            echo "{$url}\t无数据===\r\n";
            return;
        } else {
            $result = $result['data'][0];
        }

        $model = new CollectData();
        if($result['name'] && $result['addr'] && $result['phone']){
            $data = [];
            $data['name'] = $result['name'];
            $data['address'] = $result['addr'];
            $data['phone'] = $result['phone'];
            $data['url'] = $url;
            $data['cityid'] = $result['cityId'];
            $data['cateName'] = $result['cateName'];
            $data['areaName'] = $result['areaName'];
            $data['showType'] = $result['showType'];
            $data['frontImg'] = $result['frontImg'];
            $result = $model->add($data);
            if($result['status'] > 0){
                echo "{$url}\t采集成功\r\n";
            } else {
                echo "{$url}\t采集失败,原因：{$result['msg']}===\r\n";
            }
        }
    }

    public function actionIndex2($start = 100, $range = 100)
    {
        $end = $start + $range;
        for($i=$start; $i<$end; $i++){
            $this->actionCollectElm($i);
        }
    }

    public function actionCollectElm($id)
    {
        $url = self::ELM_URL .$id;
        $ua = 'Mozilla/5.0 (Linux; Android 6.0.1; 1605-A01 Build/MMB29M; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/53.0.2785.143 Crosswalk/24.53.595.0 XWEB/153 MMWEBSDK/21 Mobile Safari/537.36 MicroMessenger/6.6.7.1321(0x26060737) NetType/WIFI Language/zh_CN MicroMessenger/6.6.7.1321(0x26060737) NetType/WIFI Language/zh_CN miniProgram';
        $cookie = 'perf_ssid=r4pal75ur62uw4aywkcdd5qosmk5bhig_2018-06-11; ubt_ssid=bowg259wnpj005nzxpiljqzazzv5cw0h_2018-06-11; SID=OKK9b5Y4FjO9pE8WBlOtrV1dFPVW6tQu6N2g;';
        $curl = new Curl(false);
        $result_json = true;
        $result = $curl->setUrl($url)->setCookie($cookie)->setUserAgent($ua)->request($result_json);
        print_r($result);
        if(!isset($result) || !is_array($result) || (isset($result['name']) && isset($result['message']))){
            echo "{$url}\t无数据===\r\n";
            return;
        }

        $model = new CollectData();
        if($result['name'] && $result['address'] && $result['phone']){
            $data = [];
            $data['name'] = $result['name'];
            $data['address'] = $result['address'];
            $data['phone'] = $result['phone'];
            $data['url'] = $url;
            $result = $model->add2($data);
            if($result['status'] > 0){
                echo "{$url}\t采集成功\r\n";
            } else {
                echo "{$url}\t采集失败===\r\n";
            }
        }
    }
}
