<?php
/**
 * TestCase.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace rmrevin\yii\minify\tests\unit;

use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;

/**
 * Class TestCase
 * @package rmrevin\yii\fontawesome\tests\unit
 * This is the base class for all yii framework unit tests.
 */
abstract class TestCase extends \PHPUnit_Framework_TestCase
{

    public static $params;

    protected function setUp()
    {
        parent::setUp();
        FileHelper::createDirectory($this->getParam('components')['assetManager']['basePath']);
        file_put_contents(__DIR__ . '/runtime/compress.html', '');
        $this->mock_application();
    }

    protected function tearDown()
    {
//        unlink(__DIR__ . '/runtime/compress.html');
        FileHelper::removeDirectory($this->getParam('components')['view']['minify_path']);
        FileHelper::removeDirectory($this->getParam('components')['assetManager']['basePath']);
        $this->destroyApplication();
        parent::tearDown();
    }

    /**
     * Populates Yii::$app with a new application
     * The application will be destroyed on tearDown() automatically.
     * @param string $appClass
     */
    protected function mock_application($appClass = '\yii\console\Application')
    {
        // for update self::$params
        $this->getParam('id');

        /** @var \yii\console\Application $app */
        new $appClass(self::$params);
    }

    /**
     * Destroys the application instance created by [[mockApplication]].
     */
    protected function destroyApplication()
    {
        \Yii::$app = null;
    }

    /**
     * Returns a test configuration param from /data/config.php
     * @param string $name params name
     * @param mixed $default default value to use when param is not set.
     * @return mixed the value of the configuration param
     */
    public function getParam($name, $default = null)
    {
        if (self::$params === null) {
            self::$params = require(__DIR__ . '/config/main.php');
            $main_local = __DIR__ . '/config/main-local.php';
            if (file_exists($main_local)) {
                self::$params = ArrayHelper::merge(self::$params, require($main_local));
            }
        }

        return isset(self::$params[$name]) ? self::$params[$name] : $default;
    }
}
