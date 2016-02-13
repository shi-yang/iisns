<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (§³§Ü§Ú§Ü§³)
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @date 05.08.2015
 */
namespace iisns\assets;

use Yii;
use yii\helpers\FileHelper;
use yii\base\BootstrapInterface;
use yii\base\Component;
use yii\base\Event;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Application;
use yii\web\Response;
use yii\web\View;

/**
 * Class AssetsCompressComponent
 */
class AssetsCompressComponent extends Component implements BootstrapInterface
{
    /**
     * @var bool Enable this component
     */
    public $enabled = true;
    /**
     * @var int time in seconds for reading each file
     */
    public $readFileTimeout = 3;
    /**
     * @var bool
     */
    public $jsCompress = true;
    /**
     * @var bool Cut comments during processing js
     */
    public $jsCompressFlaggedComments = true;
    /**
     * @var bool
     */
    public $cssCompress = true;
    /**
     * @var bool Whether to merge CSS file
     */
    public $cssFileCompile = true;
    /**
     * @var bool Trying to get css files to which the specified path as a remote file
     */
    public $cssFileRemouteCompile = false;
    /**
     * @var bool Enable compression and processing before being stored in the css file
     */
    public $cssFileCompress = false;
    /**
     * @var bool Whether to merge js file
     */
    public $jsFileCompile = true;
    /**
     * @var bool Trying to get a js files to which the specified path as a remote file
     */
    public $jsFileRemouteCompile = false;
    /**
     * @var bool Enable compression and processing js before saving a file
     */
    public $jsFileCompress = true;
    /**
     * @var bool Cut comments during processing js
     */
    public $jsFileCompressFlaggedComments = true;
    /**
     * @param \yii\web\Application $app
     */
    public function bootstrap($app)
    {
        if ($app instanceof Application) {
            //Response::EVENT_AFTER_SEND,
            //$content = ob_get_clean();
            $app->view->on(View::EVENT_END_PAGE, function(Event $e) {
                /**
                 * @var $view View
                 */
                $view = $e->sender;
                if ($this->enabled && $view instanceof View && \Yii::$app->response->format == Response::FORMAT_HTML && !\Yii::$app->request->isAjax) {
                    $this->_processing($view);
                }
            });
        }
    }

    /**
     * @return string
     */
    public function getSettingsHash()
    {
        return serialize((array) $this);
    }

    /**
     * @param View $view
     */
    protected function _processing(View $view)
    {
        //Compiling js files into one.
        if ($view->jsFiles && $this->jsFileCompile) {
            foreach ($view->jsFiles as $pos => $files) {
                if ($files) {
                    $view->jsFiles[$pos] = $this->_processingJsFiles($files);
                }
            }
        }
        //Compiling js code that appears on a page
        if ($view->js && $this->jsCompress) {
            foreach ($view->js as $pos => $parts) {
                if ($parts) {
                    $view->js[$pos] = $this->_processingJs($parts);
                }
            }
        }
        //Compiling css file which is found on page
        if ($view->cssFiles && $this->cssFileCompile) {
            $view->cssFiles = $this->_processingCssFiles($view->cssFiles);
        }
        //Compiling css code which is found on page
        if ($view->css && $this->cssCompress) {
            $view->css = $this->_processingCss($view->css);
        }
    }

    /**
     * @param $parts
     * @return array
     * @throws \Exception
     */
    protected function _processingJs($parts)
    {
        $result = [];
        if ($parts) {
            foreach ($parts as $key => $value) {
                $result[$key] = \JShrink\Minifier::minify($value, ['flaggedComments' => $this->jsCompressFlaggedComments]);
            }
        }
        return $result;
    }

    /**
     * @param array $files
     * @return array
     */
    protected function _processingJsFiles($files = [])
    {
        $fileName   =  md5( implode(array_keys($files)) . $this->getSettingsHash()) . '.js';
        $publicUrl  = Yii::getAlias('@web/assets/js-compress/' . $fileName);
        $rootDir    = Yii::getAlias('@webroot/assets/js-compress');
        $rootUrl    = $rootDir . '/' . $fileName;

        if (file_exists($rootUrl)) {
            $resultFiles        = [];
            foreach ($files as $fileCode => $fileTag) {
                if (!Url::isRelative($fileCode)) {
                    $resultFiles[$fileCode] = $fileTag;
                } else {
                    if ($this->jsFileRemouteCompile) {
                        $resultFiles[$fileCode] = $fileTag;
                    }
                }
            }
            $publicUrl                  = $publicUrl . "?v=" . filemtime($rootUrl);
            $resultFiles[$publicUrl]    = Html::jsFile($publicUrl);
            return $resultFiles;
        }

        $resultContent  = [];
        $resultFiles    = [];
        foreach ($files as $fileCode => $fileTag) {
            if (Url::isRelative($fileCode)) {
                $resultContent[] = trim($this->fileGetContents( Url::to(Yii::$app->request->hostInfo . $fileCode, true) )) . "\n;";
            } else {
                if ($this->jsFileRemouteCompile) {
                    //Trying to download a remote file
                    $resultContent[] = trim($this->fileGetContents( $fileCode ));
                } else {
                    $resultFiles[$fileCode] = $fileTag;
                }
            }

        }
        if ($resultContent) {
            $content = implode($resultContent, ";\n");
            if (!is_dir($rootDir)) {
                if (!FileHelper::createDirectory($rootDir, 0777)) {
                    return $files;
                }
            }
            if ($this->jsFileCompress) {
                $content = \JShrink\Minifier::minify($content, ['flaggedComments' => $this->jsFileCompressFlaggedComments]);
            }
            $file = fopen($rootUrl, "w");
            fwrite($file, $content);
            fclose($file);
        }
        if (file_exists($rootUrl)) {
            $publicUrl                  = $publicUrl . "?v=" . filemtime($rootUrl);
            $resultFiles[$publicUrl]    = Html::jsFile($publicUrl);
            return $resultFiles;
        } else {
            return $files;
        }
    }

    /**
     * @param array $files
     * @return array
     */
    protected function _processingCssFiles($files = [])
    {
        $fileName   =  md5( implode(array_keys($files)) . $this->getSettingsHash() ) . '.css';
        $publicUrl  = Yii::getAlias('@web/assets/css-compress/' . $fileName);
        $rootDir    = Yii::getAlias('@webroot/assets/css-compress');
        $rootUrl    = $rootDir . '/' . $fileName;

        if (file_exists($rootUrl)) {
            $resultFiles = [];
            foreach ($files as $fileCode => $fileTag) {
                if (!Url::isRelative($fileCode) && !$this->cssFileRemouteCompile) {
                    $resultFiles[$fileCode] = $fileTag;
                }
            }
            $publicUrl                  = $publicUrl . "?v=" . filemtime($rootUrl);
            $resultFiles[$publicUrl]    = Html::cssFile($publicUrl);
            return $resultFiles;
        }

        $resultContent  = [];
        $resultFiles    = [];
        foreach ($files as $fileCode => $fileTag) {
            if (Url::isRelative($fileCode)) {
                $contentTmp  = trim($this->fileGetContents( Url::to(Yii::$app->request->hostInfo . $fileCode, true) ));
                $fileCodeTmp = explode("/", $fileCode);
                unset($fileCodeTmp[count($fileCodeTmp) - 1]);
                $prependRelativePath = implode("/", $fileCodeTmp) . "/";
                $contentTmp = \Minify_CSS::minify($contentTmp, [
                    "prependRelativePath" => $prependRelativePath,
                    'compress'          => true,
                    'removeCharsets'    => true,
                    'preserveComments'  => true,
                ]);
                //$contentTmp = \CssMin::minify($contentTmp);
                $resultContent[] = $contentTmp;
            } else {
                if ($this->cssFileRemouteCompile) {
                    //Trying to download a remote file
                    $resultContent[] = trim($this->fileGetContents( $fileCode ));
                } else {
                    $resultFiles[$fileCode] = $fileTag;
                }
            }
        }
        if ($resultContent) {
            $content = implode($resultContent, "\n");
            if (!is_dir($rootDir)) {
                if (!FileHelper::createDirectory($rootDir, 0777)) {
                    return $files;
                }
            }
            if ($this->cssFileCompress) {
                $content = \CssMin::minify($content);
            }
            $file = fopen($rootUrl, "w");
            fwrite($file, $content);
            fclose($file);
        }
        if (file_exists($rootUrl)) {
            $publicUrl                  = $publicUrl . "?v=" . filemtime($rootUrl);
            $resultFiles[$publicUrl]    = Html::cssFile($publicUrl);
            return $resultFiles;
        } else {
            return $files;
        }
    }


    /**
     * @param array $css
     * @return array
     */
    protected function _processingCss($css = [])
    {
        $newCss = [];
        foreach ($css as $code => $value) {
            $newCss[] = preg_replace_callback('/<style\b[^>]*>(.*)<\/style>/is', function($match) {
                return $match[1];
            }, $value);
        }
        $css = implode($newCss, "\n");
        $css = \CssMin::minify($css);
        return [md5($css) => "<style>" . $css . "</style>"];
    }

    /**
     * Read file contents
     *
     * @param $file
     * @return string
     */
    public function fileGetContents($file)
    {
        if (function_exists('curl_init')) {
            $url     =   $file;
            $ch      =   curl_init();
            $timeout =   (int) $this->readFileTimeout;

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

            $result = curl_exec($ch);
            curl_close($ch);
            return $result;
        } else {
            $ctx = stream_context_create(['http'=> [
                    'timeout' => (int) $this->readFileTimeout,  //3 Seconds
                ]
            ]);
            return file_get_contents($file, false, $ctx);
        }
    }
}
