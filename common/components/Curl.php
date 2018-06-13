<?php
/**
 * CURL基类
 * author:collins
 * date: 2018-06-08
 */

namespace common\components;


/**
 * Class Curl
 * @package common\components
 */
class Curl
{
    /**
     *最大重试次数
     */
    const MAX_TRY_TIMES = 3;
    /**
     *采集源返回格式为Json
     */
    const RETURN_JSON = true;
    /**
     *采集源返回格式为String
     */
    const RETURN_STRING = false;
    //采集源支持的字符编码列表
    private $charset_arr = ['GB2312'];
    //采集源字符编码,返回结果会转为UTF8
    private $charset = null;
    //是否返回JSON
    private $is_json = false;
    //请求方式
    private $method = 'get';
    //起始次数
    private $times = 0;
    //传递的数据
    private $data = [];
    //采集URL
    private $url = '';
    //超时设置
    private $time_out = 10;
    //IP地址
    private $ip = '';
    //refer
    private $refer = '';
    //cookie
    private $cookie = '';

    private $user_agent = '';
    private $user_agent_type = [
        'Dalvik/2.1.0 (Linux; U; Android 6.0.1; 1605-A01 Build/MMB29M)',
        'Dalvik/2.1.0 (Linux; U; Android 7.0; HUAWEI CAZ-AL10 Build/HUAWEICAZ-AL10)',
        'Dalvik/2.1.0 (Linux; U; Android 7.0; MI 5 MIUI/V9.2.2.0.NAACNEK)',
        'Dalvik/2.1.0 (Linux; U; Android 7.0; PIC-AL00 Build/HUAWEIPIC-AL00)',
        'Dalvik/2.1.0 (Linux; U; Android 5.1.1; Redmi Note 3 MIUI/V8.0.7.0.LHOCNDG)',
        'Dalvik/2.1.0 (Linux; U; Android 6.0; Redmi Note 4 MIUI/V8.5.7.0.MBFCNED)',
        'Dalvik/2.1.0 (Linux; U; Android 5.0.2; Redmi Note 2 MIUI/V9.2.2.0.LHMCNEK)',
        'Dalvik/2.1.0 (Linux; U; Android 7.0; TRT-TL10A Build/HUAWEITRT-TL10A)',
        'Dalvik/2.1.0 (Linux; U; Android 6.0.1; SM-G9350 Build/MMB29M)',
        'Dalvik/2.1.0 (Linux; U; Android 6.0; HUAWEI MT7-TL00 Build/HuaweiMT7-TL00)',
        'Dalvik/2.1.0 (Linux; U; Android 7.0; KNT-AL20 Build/HUAWEIKNT-AL20)',
        'Dalvik/2.1.0 (Linux; U; Android 7.0; DUK-AL20 Build/HUAWEIDUK-AL20)',
        'Dalvik/2.1.0 (Linux; U; Android 8.0.0; HWI-AL00 Build/HUAWEIHWI-AL00)',
        'Dalvik/2.1.0 (Linux; U; Android 6.0; Redmi Note 4X MIUI/V8.5.7.0.MBFCNED)',
        'Dalvik/2.1.0 (Linux; U; Android 7.1.2; MI 5X MIUI/V9.2.1.0.NDBCNEK)',
        'Dalvik/2.1.0 (Linux; U; Android 5.1.1; vivo Xplay5A Build/LMY47V)',
        'Dalvik/2.1.0 (Linux; U; Android 7.0; FRD-AL10 Build/HUAWEIFRD-AL10)',
        'Dalvik/2.1.0 (Linux; U; Android 5.1; OPPO R9m Build/LMY47I)',
        'Dalvik/2.1.0 (Linux; U; Android 5.1.1; OPPO R9 Plusm A Build/LMY47V)',
        'Dalvik/2.1.0 (Linux; U; Android 7.1.1; vivo X9 Build/NMF26F)',
        'Dalvik/2.1.0 (Linux; U; Android 7.0; MHA-AL00 Build/HUAWEIMHA-AL00)',
        'Dalvik/2.1.0 (Linux; U; Android 7.0; TRT-AL00A Build/HUAWEITRT-AL00A)',
        'Dalvik/2.1.0 (Linux; U; Android 7.0; MI 5 MIUI/V9.2.2.0.NAACNEK)',
        'Dalvik/2.1.0 (Linux; U; Android 7.1.1; OPPO R11s Build/NMF26X)',
        'Dalvik/2.1.0 (Linux; U; Android 7.0; DUK-AL20 Build/HUAWEIDUK-AL20)'
    ];

    /**
     * Curl constructor.
     * @param $is_json
     * @param $times
     */
    public function __construct($is_json = false, $times = 0)
    {
        if($is_json){
            $this->is_json = true;
        }
        if($times && $times <= self::MAX_TRY_TIMES){
            $this->times = $times;
        }
        //随机返回UA
        $this->user_agent = $this->user_agent_type[array_rand($this->user_agent_type,1)];
        $this->setIp();
    }

    /**
     * @param $cookie
     * @return $this
     */
    public function setCookie($cookie)
    {
        if($cookie){
            $this->cookie = $cookie;
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getCookie()
    {
        return $this->cookie;
    }

    /**
     * @param $ua
     * @return $this
     */
    public function setUserAgent($ua)
    {
        if($ua){
            $this->user_agent = $ua;
        }
        return $this;
    }

    /**
     * @return mixed|string
     */
    public function getUserAgent()
    {
        return $this->user_agent;
    }

    /**
     * @return $this
     */
    public function setIp()
    {
        $ip_long = array(
            array('607649792', '608174079'), //36.56.0.0-36.63.255.255
            array('1038614528', '1039007743'), //61.232.0.0-61.237.255.255
            array('1783627776', '1784676351'), //106.80.0.0-106.95.255.255
            array('2035023872', '2035154943'), //121.76.0.0-121.77.255.255
            array('2078801920', '2079064063'), //123.232.0.0-123.235.255.255
            array('-1950089216', '-1948778497'), //139.196.0.0-139.215.255.255
            array('-1425539072', '-1425014785'), //171.8.0.0-171.15.255.255
            array('-1236271104', '-1235419137'), //182.80.0.0-182.92.255.255
            array('-770113536', '-768606209'), //210.25.0.0-210.47.255.255
            array('-569376768', '-564133889'), //222.16.0.0-222.95.255.255
        );

        $rand_key = mt_rand(0, 9);

        $this->ip= long2ip(mt_rand($ip_long[$rand_key][0], $ip_long[$rand_key][1]));
        return $this;
    }

    /**
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param $url
     * @return $this
     */
    public function setRefer($url)
    {
        $this->refer = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getRefer()
    {
        return $this->refer;
    }

    /**
     * @param $method
     * @return $this
     */
    public function setMethod($method)
    {
        $method = strtolower($method);
        if(in_array($method, ['post'])){
            $this->method = $method;
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param $charset
     * @return $this
     */
    public function setCharset($charset)
    {
        if(in_array($charset, $this->charset_arr)){
            $this->charset = $charset;
            return $this;
        } else {
            return $this;
        }
    }

    /**
     * @return null
     */
    public function getCharset()
    {
        return $this->charset;
    }

    /**
     * @param $url
     * @return object
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param $data
     * @return $this
     */
    public function setData($data)
    {
        if(is_array($data)){
            $this->data = $data;
            return $this;
        } else {
            return $this;
        }
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * CURL访问目标网站
     * @return  string|array
     */
    public function request($result_json = false)
    {
        if($this->times > self::MAX_TRY_TIMES){
            return [];
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->url);  //设置URL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->time_out);

        if($this->method == 'post'){
            curl_setopt($ch, CURLOPT_POST, 1);
        }

        $header = $headerArr = [];

        if($this->ip){
            $header['CLIENT-IP'] = $this->ip;
            $header['X-FORWARDED-FOR'] = $this->ip;
            foreach( $header as $n => $v ) {
	            $headerArr[] = $n .':' . $v;
	        }
        }

        if($this->user_agent){
            curl_setopt($ch, CURLOPT_USERAGENT, $this->user_agent);
        }

        //生成发送数据
        $data_string = $this->buildData();
        if($this->data){
            curl_setopt($ch, CURLOPT_POSTFIELDS,  $data_string);
        }

        if($this->is_json){ //发送JSON数据
            $headerArr[] = 'Content-Type: application/json; charset=utf-8';
            $headerArr[] = 'Content-Length:' . strlen($data_string);
        }

        //设置HEADER头
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerArr);

        if($this->cookie){
            curl_setopt($ch, CURLOPT_COOKIE, $this->cookie);
        }

        $output = curl_exec($ch);
        curl_close($ch);

        if(empty($output)){
            $this->times++;
            return $this->request();
        } else {
            if($result_json){
                return json_decode($output, true);
            } else {
                return $output;
            }
        }
    }

    /**
     * @return string
     */
    private function buildData()
    {
        $data_string = "";
        if(!$this->data){
            return $data_string;
        }
        foreach ($this->data as $key=>$value) {
            $data_string .="{$key}={$value}&";
        }
        $data_string = mb_substr($data_string, 0, -1);
        return $data_string;
    }
}