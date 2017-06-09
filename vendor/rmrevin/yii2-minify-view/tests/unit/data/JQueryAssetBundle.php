<?php
/**
 * JQueryAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace rmrevin\yii\minify\tests\unit\data;

/**
 * Class JQueryAssetBundle
 * @package rmrevin\yii\minify\tests\unit\data
 */
class JQueryAssetBundle extends \yii\web\AssetBundle
{

    public $js = [
        '//code.jquery.com/jquery-1.11.2.min.js',
    ];

    public $jsOptions = [
        'position' => \rmrevin\yii\minify\View::POS_HEAD,
    ];

    public function init()
    {
        $this->sourcePath = __DIR__ . '/source';
    }
}
