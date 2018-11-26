<?php
return [
    'user.passwordResetTokenExpire' => 3600,
    'site' => [
        'url' => 'http://cms.feehi.com',
        'sign' => '###~SITEURL~###',//数据库中保存的本站地址，展示时替换成正确url
    ],
    'admin' => [
        'url' => 'http://admin.cms.feehi.com',
    ],
    'smsPlatform' => 2,
    'smsRegTemplate' => [
        1 => '',
        2 => 'SMS_116780131',
    ],

    'price_per_sms' => 10,  //默认会员价,单位:分
    'price_grade' => [  //会员价格等级,单位:分
        10 => 9,         //一级,消费满100元
        1000 => 8,         //二级,消费满1000元
        5000 => 7,          //三级,消费满10000元
        10000 => 6,          //三级,消费满10000元
    ],

    'fee_rate'=>0.01,
];
