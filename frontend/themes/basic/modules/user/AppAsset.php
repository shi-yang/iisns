<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\themes\basic\modules\user;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/user.css',
    ];
    public $js = [
        '//cdn.bootcss.com/jQuery-slimScroll/1.3.3/jquery.slimscroll.min.js',
        '//cdn.bootcss.com/modernizr/2.8.3/modernizr.min.js',
        '//cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie.min.js',
        'js/user.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
