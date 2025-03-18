<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;


use yii\web\View;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends ViteAsset
{
    public $basePath  = '@webroot/dist';
    public $baseUrl = '@web/dist';

    public $css = [
        ['sass/main.scss', 'id' => 'css-main'],
        ['sass/custom/_main.scss','fonts/simple-line-icons/simple-line-icons.min.css',]
    ];
    public $js = [
        // 'js/dashmix/bootstrap.js',
        'js/dashmix/app.js',
        'js/app.js',
    ];
    public $depends = [
        // 'yii\web\YiiAsset',
        'app\assets\BootstrapAsset',
//        'yii\bootstrap5\BootstrapAsset',
        'yii\web\JqueryAsset',
    ];

}
