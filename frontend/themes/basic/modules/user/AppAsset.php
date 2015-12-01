<?php
/**
 * @link http://www.iisns.com/
 * @copyright Copyright (c) 2015 iiSNS
 * @license http://www.iisns.com/license/
 */

namespace app\themes\basic\modules\user;

use yii\web\AssetBundle;

/**
 * @author Shiyang <dr@shiyang.me>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $sourcePath = '@app/themes/basic/modules/user/assets';
    public $css = [
        'css/user.css',
    ];
    public $js = [
        //'//cdn.bootcss.com/modernizr/2.8.3/modernizr.min.js',
        'js/modernizr.js',
        'js/user.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
