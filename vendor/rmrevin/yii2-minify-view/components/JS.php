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

        if (!empty($jsFiles)) {
            foreach ($jsFiles as $position => $files) {
                if (false === in_array($position, $this->view->js_position, true)) {
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
                                $this->process($position, [$file => $html]);
                            }
                        } else {
                            if (!empty($toMinify)) {
                                $this->process($position, $toMinify);

                                $toMinify = [];
                            }

                            $this->view->jsFiles[$position][$file] = $html;
                        }
                    }

                    if (!empty($toMinify)) {
                        $this->process($position, $toMinify);
                    }

                    unset($toMinify);
                }
            }
        }
    }

    /**
     * @param integer $position
     * @param array $files
     */
    protected function process($position, $files)
    {
        $resultFile = sprintf('%s/%s.js', $this->view->minify_path, $this->_getSummaryFilesHash($files));

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

            if (false !== $this->view->file_mode) {
                @chmod($resultFile, $this->view->file_mode);
            }
        }

        $file = $this->prepareResultFile($resultFile);

        $this->view->jsFiles[$position][$file] = Html::jsFile($file);
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
