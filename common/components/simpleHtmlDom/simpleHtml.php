<?php
/**
 *
 * User: cf8
 * Date: 18-6-11
 */

namespace common\components\simpleHtmlDom;

use common\components\Curl;

class simpleHtml
{
    const MAX_FILE_SIZE = 600000;
    const DEFAULT_TARGET_CHARSET = 'UTF-8';
    const DEFAULT_BR_TEXT = "\r\n";
    const DEFAULT_SPAN_TEXT = " ";

    /**
     * @param        $url
     * @param bool   $use_include_path
     * @param null   $context
     * @param int    $offset
     * @param int    $maxLen
     * @param bool   $lowercase
     * @param bool   $forceTagsClosed
     * @param string $target_charset
     * @param bool   $stripRN
     * @param string $defaultBRText
     * @param string $defaultSpanText
     * @return bool|SimpleHtmlDom
     */
    public function file_get_html(
        $url,
        $is_json = false,
        $use_include_path = false,
        $context = null,
        $offset = -1,
        $maxLen = -1,
        $lowercase = true,
        $forceTagsClosed = true,
        $target_charset = self::DEFAULT_TARGET_CHARSET,
        $stripRN = true,
        $defaultBRText = self::DEFAULT_BR_TEXT,
        $defaultSpanText = self::DEFAULT_SPAN_TEXT
    ) {
        $dom = new SimpleHtmlDom(null, $lowercase, $forceTagsClosed, $target_charset, $stripRN, $defaultBRText,
            $defaultSpanText);
        $contents = $this->get_curl_content($url, $context);
        print_r($contents);exit;
        if (empty($contents) || strlen($contents) > self::MAX_FILE_SIZE) {
            return false;
        }
        // The second parameter can force the selectors to all be lowercase.
        $dom->load($contents, $lowercase, $stripRN);

        return $dom;
    }

    /**
     * get html dom from string
     * @param        $str
     * @param bool   $lowercase
     * @param bool   $forceTagsClosed
     * @param string $target_charset
     * @param bool   $stripRN
     * @param string $defaultBRText
     * @param string $defaultSpanText
     * @return bool|SimpleHtmlDom
     */
    public function str_get_html(
        $str,
        $lowercase = true,
        $forceTagsClosed = true,
        $target_charset = self::DEFAULT_TARGET_CHARSET,
        $stripRN = true,
        $defaultBRText = self::DEFAULT_BR_TEXT,
        $defaultSpanText = self::DEFAULT_SPAN_TEXT
    ) {
        $dom = new SimpleHtmlDom(null, $lowercase, $forceTagsClosed, $target_charset, $stripRN, $defaultBRText,
            $defaultSpanText);
        if (empty($str) || strlen($str) > self::MAX_FILE_SIZE) {
            $dom->clear();

            return false;
        }
        $dom->load($str, $lowercase, $stripRN);

        return $dom;
    }

    /**
     * dump html dom tree
     * @param      $node
     * @param bool $show_attr
     * @param int  $deep
     */
    public function dump_html_tree($node, $show_attr = true, $deep = 0)
    {
        $node->dump($node);
    }

    /**
     * @param string    $url
     * @param array     $content
     * @return string
     */
    public function get_curl_content($url, $content)
    {
        $curl = new Curl(false);
        $curl->setUrl($url)->setData($content);
        $result = $curl->request();

        return $result;
    }
}