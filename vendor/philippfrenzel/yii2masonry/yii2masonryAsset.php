<?php

namespace yii2masonry;

use yii\web\AssetBundle;

/**
 * @link http://www.frenzel.net/
 * @author Philipp Frenzel <philipp@frenzel.net> 
 */

class yii2masonryAsset extends AssetBundle
{
    public $sourcePath = '@bower/masonry/dist';

    /**
     * [$autoGenerate description]
     * @var boolean
     */
    public $autoGenerate = true;
    
    public $css = array();
    
    public $js = array(
        'masonry.pkgd.min.js'
    );

    public $depends = array(
        'yii\web\JqueryAsset',
    );
}
