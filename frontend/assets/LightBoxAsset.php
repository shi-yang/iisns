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
class LightBoxAsset extends AssetBundle
{
    public $sourcePath = '@app/assets/lightbox';
    public $css = [
        'css/lightbox.css'
    ];
    public $js = [
        'js/lightbox.min.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
