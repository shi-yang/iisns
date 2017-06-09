<?php
/**
 * JS.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace rmrevin\yii\minify\components;

use yii\helpers\Html;

/**
 * Class JS
 * @package rmrevin\yii\minify\components
 */
class JS extends MinifyComponent
{

    public function export()
    {
        $jsFiles = $this->view->jsFiles;

        $jsPosition = $this->view->jsPosition;
        $jsOptions = $this->view->jsOptions;

        if (!empty($jsFiles)) {
            foreach ($jsFiles as $position => $files) {
                if (false === in_array($position, $jsPosition, true)) {
                    $this->view->jsFiles[$position] = [];

                    foreach ($files as $file => $html) {
                        $this->view->jsFiles[$position][$file] = $html;
                    }
                } else {
                    $this->view->jsFiles[$position] = [];

                    $toMinify = [];

                    foreach ($files as $file => $html) {
                        if ($this->thisFileNeedMinify($file, $html)) {
                            if ($this->view->concatJs) {
                                $toMinify[$file] = $html;
                            } else {
                                $this->process($position, $jsOptions, [$file => $html]);
                            }
                        } else {
                            if (!empty($toMinify)) {
                                $this->process($position, $jsOptions, $toMinify);

                                $toMinify = [];
                            }

                            $this->view->jsFiles[$position][$file] = $html;
                        }
                    }

                    if (!empty($toMinify)) {
                        $this->process($position, $jsOptions, $toMinify);
                    }

                    unset($toMinify);
                }
            }
        }
    }

    /**
     * @param integer $position
     * @param array $options
     * @param array $files
     */
    protected function process($position, $options, $files)
    {
        $resultFile = sprintf('%s/%s.js', $this->view->minifyPath, $this->_getSummaryFilesHash($files));

        if (!file_exists($resultFile)) {
            $js = '';

            foreach ($files as $file => $html) {
                $file = $this->getAbsoluteFilePath($file);

                $content = '';

                if (!file_exists($file)) {
                    \Yii::warning(sprintf('Asset file not found `%s`', $file), __METHOD__);
                } elseif (!is_readable($file)) {
                    \Yii::warning(sprintf('Asset file not readable `%s`', $file), __METHOD__);
                } else {
                    $content .= file_get_contents($file) . ';' . "\n";
                }

                $js .= $content;
            }

            $this->removeJsComments($js);

            if ($this->view->minifyJs) {
                $js = (new \JSMin($js))
                    ->min();
            }

            file_put_contents($resultFile, $js);

            if (false !== $this->view->fileMode) {
                @chmod($resultFile, $this->view->fileMode);
            }
        }

        $file = $this->prepareResultFile($resultFile);

        $this->view->jsFiles[$position][$file] = Html::jsFile($file, $options);
    }

    /**
     * @todo
     * @param string $code
     */
    protected function removeJsComments(&$code)
    {
        if (true === $this->view->removeComments) {
            //$code = preg_replace('', '', $code);
        }
    }
}
