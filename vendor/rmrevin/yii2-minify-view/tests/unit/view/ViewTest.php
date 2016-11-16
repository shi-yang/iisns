<?php
/**
 * ViewTest.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace rmrevin\yii\minify\tests\unit\view;

use rmrevin\yii\minify;
use yii\helpers\FileHelper;
use yii\helpers\Url;

/**
 * Class ViewTest
 * @package rmrevin\yii\minify\tests\unit\view
 */
class ViewTest extends minify\tests\unit\TestCase
{

    public function testMain()
    {
        $this->assertInstanceOf('rmrevin\yii\minify\View', $this->getView());

        $this->assertEquals('CP1251', $this->getView()->force_charset);
    }

    public function testEmptyBundle()
    {
        $view = $this->getView();

        minify\tests\unit\data\EmptyAssetBundle::register($this->getView());

        ob_start();
        echo '<html>This is test page</html>';

        $view->endBody();
        $view->endPage(false);

        $files = FileHelper::findFiles($this->getView()->minify_path);

        $this->assertEquals(0, count($files));

        foreach ($files as $file) {
            $this->assertNotEmpty(file_get_contents($file));
        }
    }

    public function testEndPage()
    {
        $view = $this->getView();

        minify\tests\unit\data\TestAssetBundle::register($this->getView());

        ob_start();
        echo '<html>This is test page</html>';

        $view->endBody();
        $view->endPage(false);

        $files = FileHelper::findFiles($this->getView()->minify_path);

        $this->assertEquals(2, count($files));

        foreach ($files as $file) {
            $this->assertNotEmpty(file_get_contents($file));
        }
    }

    public function testAlternativeEndPage()
    {
        $view = $this->getView();

        $view->expand_imports = false;
        $view->force_charset = false;

        minify\tests\unit\data\TestAssetBundle::register($this->getView());

        ob_start();
        echo '<html>This is test page</html>';

        $view->endBody();
        $view->endPage(false);
    }

    public function testMainWithVersion()
    {
        $view = $this->getView();
        $view->assetManager->appendTimestamp = true;

        $this->assertInstanceOf(minify\View::className(), $view);

        $this->assertEquals('CP1251', $view->force_charset);
    }

    public function testEndPageWithVersion()
    {
        $view = $this->getView();
        $view->assetManager->appendTimestamp = true;

        minify\tests\unit\data\TestAssetBundle::register($view);

        ob_start();
        echo '<html>This is test page with versioning</html>';

        $view->endBody();

        $this->assertEquals(2, count($view->jsFiles[minify\View::POS_HEAD]));
        $this->assertEquals(1, count($view->jsFiles[minify\View::POS_READY]));

        $view->endPage(false);

        $files = FileHelper::findFiles($view->minify_path);

        $this->assertEquals(2, count($files));

        foreach ($files as $file) {
            $this->assertNotEmpty(file_get_contents($file));
        }
    }

    public function testAlternativeEndPageWithVersion()
    {
        $view = $this->getView();
        $view->assetManager->appendTimestamp = true;

        $view->expand_imports = false;
        $view->force_charset = false;

        minify\tests\unit\data\TestAssetBundle::register($view);

        ob_start();
        echo '<html>This is test page versioning</html>';

        $view->endBody();

        $this->assertEquals(2, count($view->jsFiles[minify\View::POS_HEAD]));
        $this->assertEquals(1, count($view->jsFiles[minify\View::POS_READY]));

        foreach ($view->jsFiles[minify\View::POS_HEAD] as $file => $html) {
            if (Url::isRelative($file)) {
                $this->assertTrue(strpos($file, '?v=') !== false);
            }
        }

        foreach ($view->jsFiles[minify\View::POS_READY] as $file => $html) {
            if (Url::isRelative($file)) {
                $this->assertTrue(strpos($file, '?v=') !== false);
            }
        }

        $view->endPage(false);
    }

    public function testFiletimeCheckAlgorithm()
    {
        $view = $this->getView();
        $view->fileCheckAlgorithm = 'filemtime';

        minify\tests\unit\data\TestAssetBundle::register($view);

        ob_start();
        echo '<html>This is test page versioning</html>';

        $view->endBody();

        $this->assertEquals(2, count($view->jsFiles[minify\View::POS_HEAD]));
        $this->assertEquals(1, count($view->jsFiles[minify\View::POS_READY]));

        $view->endPage(false);
    }

    public function testExcludeBundle()
    {
        $view = $this->getView();
        $view->excludeBundles = [
            minify\tests\unit\data\ExcludedAssetBundle::className(),
        ];

        minify\tests\unit\data\TestAssetBundle::register($view);
        minify\tests\unit\data\ExcludedAssetBundle::register($view);

        ob_start();
        echo '<html>This is test page versioning</html>';

        $view->endBody();

        $this->assertEquals(2, count($view->cssFiles));

        $view->endPage(false);
    }

    /**
     * @return minify\View
     */
    private function getView()
    {
        return \Yii::$app->getView();
    }
}
