<?php
/**
 * @link http://www.iisns.com/
 * @copyright Copyright (c) 2015 iiSNS
 * @license http://www.iisns.com/license/
 */

namespace common\widgets\editormd;

use yii\web\AssetBundle;

/**
 * @author Shiyang <dr@shiyang.me>
 */
class EditormdAsset extends AssetBundle
{
    public $sourcePath = '@common/widgets/editormd/assets';
    public $js = [
        'editormd.min.js'
    ];
    public $css = [
        'css/editormd.min.css',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
