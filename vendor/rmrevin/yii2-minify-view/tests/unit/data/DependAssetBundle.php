<?php
/**
 * DependAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace rmrevin\yii\minify\tests\unit\data;

/**
 * Class DependAssetBundle
 * @package rmrevin\yii\minify\tests\unit\data
 */
class DependAssetBundle extends \yii\web\AssetBundle
{

    public $js = [
        'depend.js',
    ];

    public $css = [
        'depend.css',
    ];

    public $jsOptions = [
        'position' => \rmrevin\yii\minify\View::POS_HEAD,
    ];

    public $depends = [
        'rmrevin\yii\minify\tests\unit\data\JQueryAssetBundle',
    ];

    public function init()
    {
        $this->sourcePath = __DIR__ . '/source';
    }
}
