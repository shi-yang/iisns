<?php
/**
 * @link https://github.com/nirvana-msu/yii2-infinite-scroll
 * @copyright Copyright (c) 2014 Alexander Stepanov
 * @license MIT
 */

namespace shiyang\infinitescroll;

use Yii;
use yii\web\AssetBundle;

/**
 * @author Alexander Stepanov <student_vmk@mail.ru>
 */
class InfiniteScrollAsset extends AssetBundle
{
    public $sourcePath = '@bower/jquery-infinite-scroll';
    public $css = [
    ];
    public $js = [  // Configured conditionally (source/minified) during init()
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public function init()
    {
        parent::init();
        $this->js[] = YII_DEBUG ? 'jquery.infinitescroll.js' : 'jquery.infinitescroll.min.js';

        $this->publishOptions['beforeCopy'] = function ($from) {
            $path = str_replace(realpath(Yii::getAlias('@bower') . '\jquery-infinite-scroll'), '', $from);
            return
                $path !== DIRECTORY_SEPARATOR.'site'
                && $path !== DIRECTORY_SEPARATOR.'wordpress-plugin';
        };
    }
}
