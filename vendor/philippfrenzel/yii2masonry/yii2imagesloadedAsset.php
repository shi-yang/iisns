<?php

namespace yii2masonry;

use yii\web\AssetBundle;

/**
 * @link http://www.frenzel.net/
 * @author Philipp Frenzel <philipp@frenzel.net> 
 */

class yii2imagesloadedAsset extends AssetBundle
{
    public $sourcePath = '@bower/imagesloaded';

    /**
     * [$autoGenerate description]
     * @var boolean
     */
    public $autoGenerate = true;
    
    public $css = array();
    
    public $js = array(
        'imagesloaded.pkgd.min.js'
    );

    public $depends = array(
        'yii\web\JqueryAsset',
    );
}
