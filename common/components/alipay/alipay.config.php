<?php
/* *
 * 配置文件
 * 版本：1.0
 * 日期：2016-06-06
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。
*/
//↓↓↓↓↓↓↓↓↓↓请在这里配置您的基本信息↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
//合作身份者ID，签约账号，以2088开头由16位纯数字组成的字符串，查看地址：https://openhome.alipay.com/platform/keyManage.htm?keyType=partner
$alipay_config['partner'] = "2018092461536281";
//商户的私钥,此处填写原始私钥去头去尾，RSA公私钥生成：https://doc.open.alipay.com/doc2/detail.htm?spm=a219a.7629140.0.0.nBDxfy&treeId=58&articleId=103242&docType=1
$alipay_config['private_key'] = 'MIIEowIBAAKCAQEAvFk/cN2TiOG0z4s0wdcOd+Li5zwj+H+3qg8s2GxtDAMZfuS2mCdMOvxxV/6DHvth5+kUgWpkV7VbNw9FxgbgABPUFygGSAhu8ldzVSspF55nI1Se/iFDffTsEYG+U1v7ZqF87ojycxEVGJd9u1MBN8oImM/nHvHmHGo4hRVEGGocT+RVWKcnG5Xdghz24Uyn/idTyRA7ZUkd9HapFcNF03hwPeRFYuuNJSoQgFwlN8n/Km/LOThbKnxaLEfTMytTgyzB9UYbclQagLTfSZQyCYfiZKPGrjEKX8LeRBC8+T17mVHITZD+1EBYQ2JuO4LaJFKYgMCZ4rSDr4mbE23q7wIDAQABAoIBACyb7ryqniDTZGGrlMk8SD74y8j8o4Bdr4Blq7dupr0rlsRJIz4SQKnP1ICE1UVnQJ8Owz6Llkx3tazqvxnR0wfxqk/5uNMivDRFphlL6aWgbMkfZ7DE7BlPAwJ6ejuAE6ERKmfMo6/BIf/7EVpmpGk0PqkCxLi9jkS4m75ZdRFa1+KxiGhkKdIS+hJDUpIxsvU0ttZsNxB1GibPg0KRFsbs7Qhx7q6DhNFr2acj/j52vUMpCTN+S94I9jjJZttoqAuAh22psB4nfK86rQ/jMd078B26SElIeM4G3Hq9ZSVpa4cliJr+1hI0gtSdHv3LnpQWRNdJoVgJ9938nlM+XNECgYEA8tgaypaiu9SM5UfG/DchnwBn+Pb+H+gq9HXvLLalIrGP5cvZzjn3/tNiucer15r9ssqhqCmzeWplkXhiRPSdnV4xC38Q7X8POYye11tldtZRl3kUvW+O6kfrsb/nT6upBe7uoqXceIFOPbb0PpLn1NySq7SNk4j2gTIhZnAJFpUCgYEAxo1ejVT9r8BXozQ1509rs1iYRCx/27/xjkQmilsnWdrlRqNFsFD+DmtdRdl7Z5j0nG56lDEjt59akJlALCpO+3G7HKXBG3skgZSrc0F3b2zoKS56yGcHKId4AKb2qgyF9qmLju+W88ClS+jB6OPFd3sPoq/KhDp7vle6y8eiLnMCgYBhCsSiAlIjdwuar/UvYqSX0mS6E5F3lKJdsCcUmiQhWg1jyfNOutGETlqcXNMpxHDvGpRBC/EBaugNmqrCXXICqdo1euB715Nw7uWmr4o7U+ek/SixjrvwmS7xh/taVgGkMlfAPUF+EkX+2XZ+7tufr0kZPnx44XmIJU09jzXChQKBgQCHuuJ1GTGm8IS4Y5upuYg1fQ3yJL1u+qLljz8Ne8zFxzbO+BROuL9EGi8T7d1Hb69gNMIFBiaVgxEFIk5VIsMFbrTrm4AMCj1le71Mt+cuu7NlW4nB73RcR2dIgtrCWndFrJdjqfN2RC57Wu0cCIDX8b85hpSZmeU3tH9UiO8ccwKBgH+r8q9dzW+oo5SASvXjgz50XmGHR5WIJYc+VMBjc/gTVXDX2cGroYVJwC5tPZWM/Xwk29pSwUJQb7I+l3nx2iFtpYfumOej8SAPWuuodT8DAYe7f0l/uekkTk7DV38JFEf4XdKKT+GcZwBSNnB8DWMAUsKNqDa7cAFuYHrbDVtp';


//支付宝的公钥，查看地址：https://openhome.alipay.com/platform/keyManage.htm?keyType=partner
$alipay_config['alipay_public_key']= 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDDI6d306Q8fIfCOaTXyiUeJHkrIvYISRcc73s3vF1ZT7XN8RNPwJxo8pWaJMmvyTn9N4HQ632qJBVHf8sxHi/fEsraprwCtzvzQETrNRwVxLO5jVmRGi60j8Ue1efIlzPXV9je9mkjzOmdssymZkh2QhUrCmZYI/FCEa3/cNMW0QIDAQAB';

//异步通知接口
$alipay_config['service']= 'mobile.securitypay.pay';
//↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑

//签名方式 不需修改
$alipay_config['sign_type']    = strtoupper('RSA');

//字符编码格式 目前支持 gbk 或 utf-8
$alipay_config['input_charset']= strtolower('utf-8');

//ca证书路径地址，用于curl中ssl校验
//请保证cacert.pem文件在当前文件夹目录中
$alipay_config['cacert']    = getcwd().'/cacert.pem';

//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
$alipay_config['transport']    = 'http';

//支付成功回调地址
//$alipay_config['notify_url']    = 'http://mobile2.cf8.cn/pay.php?code=alipay';

