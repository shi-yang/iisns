<?php
/**
 * @link http://www.iisns.com/
 * @copyright Copyright (c) 2015 iiSNS
 * @license http://www.iisns.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Shiyang <dr@shiyang.me>
 * @since 2.0
 */
class CommonAsset extends AssetBundle
{
    public $sourcePath = '@app/assets/common';
    public $css = [
    ];
    public $js = [
        'js/common.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
