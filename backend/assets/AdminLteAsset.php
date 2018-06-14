<?php
/**
 * @link http://www.iisns.com/
 * @copyright Copyright (c) 2015 iiSNS
 * @license http://www.iisns.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * @author Shiyang <dr@shiyang.me>
 */
class AdminLteAsset extends AssetBundle
{
    public $sourcePath = '@app/assets/adminlte';
    public $css = [
        'css/adminlte.min.css',
        'css/skins/skin-blue.min.css',
        'https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css',
    ];
    public $js = [
        'js/adminlte.js',
        'js/plugins/bootstrap/js/bootstrap.bundle.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
