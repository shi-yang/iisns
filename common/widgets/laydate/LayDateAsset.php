<?php
/**
 * @link http://www.iisns.com/
 * @copyright Copyright (c) iiSNS
 */
namespace common\widgets\laydate;

use yii\web\AssetBundle;

/**
 * @author Shiyang <dr@shiyang.me>
 */
class LayDateAsset extends AssetBundle
{
    public $sourcePath = '@common/widgets/Laydate/assets';

    public $js = [
        'laydate.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
