<?php
return [
    'id' => 'app-common-tests',
    'basePath' => dirname(__DIR__),
    'components' => [
        'user' => [
            'class' => yii\web\User::className(),
            'identityClass' => backend\models\User::className(),
        ],
    ],
    'params' => yii\helpers\ArrayHelper::merge(
        require __DIR__ . '/params.php',
        require __DIR__ . '/params-local.php'
    )
];
