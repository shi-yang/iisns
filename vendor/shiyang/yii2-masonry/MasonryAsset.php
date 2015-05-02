<?php

namespace shiyang\masonry;

use yii\web\AssetBundle;

/**
 * @link http://www.frenzel.net/
 * @author Shiyang <dr@shiyang.me> 
 */

class MasonryAsset extends AssetBundle
{
    public $sourcePath = '@bower/masonry/dist';

    public $css = [];
    
    public $js = [
        'masonry.pkgd.min.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
