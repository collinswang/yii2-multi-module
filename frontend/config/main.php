<?php

use yii\filters\ContentNegotiator;
use yii\web\Response;

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log',
        [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
                'application/xml' => Response::FORMAT_XML,
            ],
            'languages' => [
                'en-US',
                'de',
            ],
        ],
        ],
    'controllerNamespace' => 'frontend\controllers',
    'defaultRoute' => 'index/index',
    'components' => [
        'user' => [
            'identityClass' => common\models\User::className(),
            'enableAutoLogin' => true,
        ],
        'session' => [
            'timeout' => 1440,//session过期时间，单位为秒
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => yii\log\FileTarget::className(),
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
//        'cache' => [
//            'class' => yii\caching\FileCache::className(),//使用文件缓存，可根据需要改成apc redis memcache等其他缓存方式
//            'keyPrefix' => 'frontend',       // 唯一键前缀
//        ],
        'urlManager' => [
            'enablePrettyUrl' => false,
            'showScriptName' => true,//隐藏index.php
            'enableStrictParsing' => false,
            //'suffix' => '.html',//后缀，如果设置了此项，那么浏览器地址栏就必须带上.html后缀，否则会报404错误
//            'rules' => [
//                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
//                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>?id=<id>',
//                'detail/<id:\d+>' => 'site/detail?id=$id',
//                'post/22'=>'site/detail',
//                '<controller:detail>/<id:\d+>' => '<controller>/index',
//                '' => 'index/index',
//                '<page:\d+>' => 'article/index',
//                'login' => 'site/login',
//                'signup' => 'site/signup',
//                'view/<id:\d+>' => 'article/view',
//                'page/<name:\w+>' => 'page/view',
//                'comment' => 'article/comment',
//                'search' => 'search/index',
//                'tag/<tag:\w+>' => 'search/tag',
//                'rss' => 'article/rss',
//                'list/<page:\d+>' => 'site/index',
 //           ],
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => yii\i18n\PhpMessageSource::className(),
                    'basePath' => '@backend/messages',
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',

                    ],
                ],
                'front*' => [
                    'class' => yii\i18n\PhpMessageSource::className(),
                    'basePath' => '@frontend/messages',
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'frontend' => 'frontend.php',
                        'app/error' => 'error.php',

                    ],
                ],
                'menu' => [
                    'class' => yii\i18n\PhpMessageSource::className(),
                    'basePath' => '@frontend/messages',
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'app' => 'menu.php',
                        'app/error' => 'error.php',
                    ],
                ],
            ],
        ],
        'assetManager' => [
            'linkAssets' => false,
            'bundles' => [
                yii\web\JqueryAsset::className() => [
                    'js' => [],
                ],
                frontend\assets\AppAsset::className() => [
                    'css' => [
                        'static/css/bootstrap.min14ed.css?v=3.3.6',
                        //'//cdn.bootcss.com/bootstrap/3.3.6/css/bootstrap.min.css',
                        'static/css/font-awesome.min93e3.css?v=4.4.0',
                        'static/css/animate.min.css',
                        'static/css/style.min862f.css?v=4.1.0',
                        'static/css/plugins/sweetalert/sweetalert.css',
                        'static/js/plugins/layer/laydate/need/laydate.css',
                        //'js/plugins/layer/laydate/skins/default/laydate.css'
                        'static/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css',
                        'static/css/plugins/toastr/toastr.min.css',
                    ],
                    'js' => [
                        'a' => 'static/js/jquery.min.js',
                        'b' => 'static/js/index.js',
                        'c' => 'static/plugins/toastr/toastr.min.js',
                    ],
                ],
                frontend\assets\IndexAsset::className() => [
                    'css' => [
                        'static/css/bootstrap.min.css',
                        'static/css/font-awesome.min93e3.css',
                    ]
                ],
            ]
        ]
    ],
    'params' => $params,
    'on beforeRequest' => [feehi\components\Feehi::className(), 'frontendInit'],
];
