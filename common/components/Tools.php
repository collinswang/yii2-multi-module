<?php
/**
 * 工具类
 * User: cf8
 * Date: 18-3-22
 * Time: 上午10:34
 */

namespace common\components;


class Tools
{
    /**
     * 用户输入安全过滤函数
     * @param     $content
     * @param int $role
     * @return mixed
     */
    public static function check_input($content, $role = 0)
    {
        if($role){
            $content = trim(self::filter_sql($content));
        } else {
            $content = strip_tags(trim(self::filter_sql($content)));
        }
        return $content;
    }

    public static function filter_sql($content) {
        $sql = array("select", 'insert', 'from', "update", "delete", "\'", "\/\*",
            "\.\.\/", "\.\/", "union", "into", "load_file", "outfile");
        $sql_re = array("","","","","","","","","","","","");
        $content = str_replace($sql, $sql_re, strtolower($content));
        return $content;
    }

    /**
     * 获取用户IP
     * @return string
     */
    public static function get_ip()
    {
        $ip = 'unknown';
        $headers = array('HTTP_X_REAL_FORWARDED_FOR', 'HTTP_X_FORWARDED_FOR', 'HTTP_CLIENT_IP', 'REMOTE_ADDR');
        foreach ($headers as $h){
            $ip = $_SERVER[$h];
            // 有些ip可能隐匿，即为unknown
            if ( isset($ip) && strcasecmp($ip, 'unknown') ){
                break;
            }
        }
        if( $ip ){
            // 可能通过多个代理，其中第一个为真实ip地址
            list($ip) = explode(', ', $ip, 2);
        }
        return $ip;
    }
}