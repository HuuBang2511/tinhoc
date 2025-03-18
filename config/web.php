<?php
$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'timeZone' => 'Asia/Ho_Chi_Minh',
    'language' => 'vi-VN',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'dynamicParams'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'dynamicParams' => [
            'class' => 'app\components\DynamicParams'
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'b02e76301d76a8166b3e0c296ae28a6abc2b7580',
            'csrfCookie' => [
                'httpOnly' => true,
                'secure' => true,
            ],
            //'hostInfo' => 'https://quanlykinhte.hcmgis.vn'
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        // 'user' => [
        //     'identityClass' => 'hcmgis\user\models\AuthUser',
        //     'loginUrl' => ['user/auth/login'],
        //     'enableAutoLogin' => false,
        // ],
        'errorHandler' => [
            'errorAction' => 'quanly/default/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [],
        ],
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap5\BootstrapAsset' => false,
                'yii\bootstrap5\BootstrapPluginAsset' => false,
            ],
        ],
        'session' => [
            'class' => 'yii\web\DbSession',
            'writeCallback' => function ($session) {
                if (Yii::$app->request->isAjax || Yii::$app->request->isPost) return;
                return [
                    'user_id' => Yii::$app->user->id,
                    'last_write' => time(),
                    'action' => Yii::$app->request->pathInfo
                ];
            },
            'timeout' => '600',
            'cookieParams' => [
                'httpOnly' => true,
                'secure' => true,
            ],
        ],

    ],
    'params' => $params,
    'modules' => [
        'gridview' =>  [
            'class' => 'app\widgets\gridview\Module',
            'bsVersion' => '5'
        ],
        'cms' => [
            'class' => 'app\modules\cms\Module'
        ],
        'map' => [
            'class' => 'app\modules\map\Module'
        ],
        // 'auth' => [
        //     'class' => 'app\modules\auth\Module',
        //     'layout' => "@app/views/layouts/topmenu/main"
        // ],
        // 'user' => [
        //     'class' => 'hcmgis\user\Module',
        //     'actionModules' => ['quan-ly-danh-muc', 'quan-ly-dan-cu', 'map','quanly', 'auth', 'danhmuc'], // Danh sách module cần phân quyền
        //     'layout' => "@app/views/layouts/topmenu/main",
        // ],
        'activity' => [
            'class' => 'hcmgis\yiicontrib\activity\Module',
        ],
        'quanly' => [
            'class' => 'app\modules\quanly\Module'
        ],
        'danhmuc' => [
            'class' => 'app\modules\danhmuc\Module'
        ],
        'contrib' => [
            'class' => 'app\modules\contrib\Module'
        ],
        // 'backup' =>  [
        //     'class' => 'floor12\backup\Module',
        //     'backupFolder' => '@webroot/backups',
        //     'administratorRoleName' => '@',
        //     'adminLayout' => '@app/views/layouts/topmenu/main',
        //     'configs' => [
        //         'postgres_db' => [
        //             'type' => \floor12\backup\models\BackupType::FILES,
        //             'title' => 'PostgreSQL',
        //             'limit' => 0,
        //             'io' => \floor12\backup\models\IOPriority::IDLE,
        //             'connection' => 'db', // component from app config, usually 'db'
        //             'path' => '@webroot/backups',
        //         ],
        //     ]
        // ]
    ],
    // 'as beforeRequest' => [
    //     'class' => 'yii\filters\AccessControl',
    //     'rules' => [
    //         [
    //             'allow' => true,
    //             'actions' => ['login', 'soluong-donvikinhte', 'danhsach-donvikinhte', 'danhsach1-donvikinhte', 'find-donvikinhte', 'thongke-donvikinhte'],
    //         ],
    //         [
    //             'allow' => true,
    //             'roles' => ['@'],
    //         ],
    //     ]
    // ],
//    'as hostControl' => [
//        'class' => 'yii\filters\HostControl',
//        'allowedHosts' => [
//            'example.com',
//            '*.example.com',
//        ],
//        'fallbackHostInfo' => 'https://quanlykinhte.hcmgis.vn',
//    ],
    'defaultRoute' => 'quanly',

];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    // $config['bootstrap'][] = 'debug';
    // $config['modules']['debug'] = [
    //     'class' => 'yii\debug\Module',
    //     // uncomment the following to add your IP if you are not connecting from localhost.
    //     //'allowedIPs' => ['127.0.0.1', '::1'],
    // ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    // $config['modules']['gridview'] = [
    //     'class' => 'app\widgets\gridview\Module',
    //     'bsVersion' => '4'
    // ];
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.0.*', '192.168.178.20'],
        'generators' => [
            'DCrud' => [
                'class' => 'app\widgets\crud\generators\Generator',
            ]
        ],
    ];
}

return $config;
