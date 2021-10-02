<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'telegram' => [
            'class' => 'aki\telegram\Telegram',
            'botToken' => '<specify_bot_token_here>',
            'botUsername' => '<specify_bot_username_here>'
        ],
    ],
];
