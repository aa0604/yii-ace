<?php

namespace xing\ace;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    /**
     * @var string 定义使用的目录路径
     */
    public $basePath = '@xing/ace/assets/';

    /**
     * @var string 定义使用的目录路径
     */
    public $sourcePath = '@xing/ace/assets';

    /**
     * @var array 加载的公共css
     */
    public $css = [
        'css/bootstrap.min.css',
        'css/font-awesome.min.css',
        'css/ace-fonts.css',
    ];

    /**
     * @var array 定义默认加载的js
     */
    public $js = [
        'js/ace-elements.min.js',
        'js/ace.min.js',
    ];

    /**
     * @var array 定义加载的配置
     */
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
