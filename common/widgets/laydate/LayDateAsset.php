<?php
/**
 * @link http://www.iisns.com/
 * @copyright Copyright (c) 2015 iiSNS
 * @license http://www.iisns.com/license/
 */

namespace common\widgets\laydate;

use yii\web\AssetBundle;

/**
 * @author Shiyang <dr@shiyang.me>
 */
class LayDateAsset extends AssetBundle
{
    public $sourcePath = '@common/widgets/laydate/assets';

    public $js = [
        'laydate.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
