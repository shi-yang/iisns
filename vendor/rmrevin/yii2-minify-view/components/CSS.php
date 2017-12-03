<?php
/**
 * CSS.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace rmrevin\yii\minify\components;

use tubalmartin\CssMin\Minifier as CSSmin;
use yii\helpers\Html;

/**
 * Class CSS
 * @package rmrevin\yii\minify\components
 */
class CSS extends MinifyComponent
{

    public function export()
    {
        $cssFiles = $this->view->cssFiles;

        $this->view->cssFiles = [];

        $toMinify = [];

        if (!empty($cssFiles)) {
            foreach ($cssFiles as $file => $html) {
                if ($this->thisFileNeedMinify($file, $html)) {
                    if ($this->view->concatCss) {
                        $toMinify[$file] = $html;
                    } else {
                        $this->process([$file => $html]);
                    }
                } else {
                    if (!empty($toMinify)) {
                        $this->process($toMinify);

                        $toMinify = [];
                    }

                    $this->view->cssFiles[$file] = $html;
                }
            }
        }

        if (!empty($toMinify)) {
            $this->process($toMinify);
        }

        unset($toMinify);
    }

    /**
     * @param array $files
     */
    protected function process(array $files)
    {
        $resultFile = $this->view->minifyPath . DIRECTORY_SEPARATOR . $this->_getSummaryFilesHash($files) . '.css';

        if (!file_exists($resultFile)) {
            $css = '';

            foreach ($files as $file => $html) {
                $path = dirname($file);
                $file = $this->getAbsoluteFilePath($file);

                $content = '';

                if (!file_exists($file)) {
                    \Yii::warning(sprintf('Asset file not found `%s`', $file), __METHOD__);
                } elseif (!is_readable($file)) {
                    \Yii::warning(sprintf('Asset file not readable `%s`', $file), __METHOD__);
                } else {
                    $content = file_get_contents($file);
                }

                $result = [];

                preg_match_all('|url\(([^)]+)\)|is', $content, $m);
                if (!empty($m[0])) {
                    foreach ($m[0] as $k => $v) {
                        if (in_array(strpos($m[1][$k], 'data:'), [0, 1], true)) {
                            continue;
                        }

                        $url = str_replace(['\'', '"'], '', $m[1][$k]);

                        if ($this->isUrl($url)) {
                            $result[$m[1][$k]] = $url;
                        } else {
                            $result[$m[1][$k]] = $path . '/' . $url;
                        }
                    }

                    $content = strtr($content, $result);
                }

                $css .= $content;
            }

            $this->expandImports($css);

            $this->removeCssComments($css);

            if ($this->view->minifyCss) {
                $css = (new CSSmin())
                    ->run($css, $this->view->cssLinebreakPos);
            }

            $charsets = false !== $this->view->forceCharset
                ? ('@charset "' . (string)$this->view->forceCharset . '";' . "\n")
                : $this->collectCharsets($css);

            $imports = $this->collectImports($css);
            $fonts = $this->collectFonts($css);

            file_put_contents($resultFile, $charsets . $imports . $fonts . $css);

            if (false !== $this->view->fileMode) {
                @chmod($resultFile, $this->view->fileMode);
            }
        }

        $file = $this->prepareResultFile($resultFile);

        $this->view->cssFiles[$file] = Html::cssFile($file);
    }

    /**
     * @param string $code
     */
    protected function removeCssComments(&$code)
    {
        if (true === $this->view->removeComments) {
            $code = preg_replace('#/\*(?:[^*]*(?:\*(?!/))*)*\*/#', '', $code);
        }
    }

    /**
     * @param string $code
     */
    protected function expandImports(&$code)
    {
        if (true === $this->view->expandImports) {
            preg_match_all('|\@import\s([^;]+);|is', str_replace('&amp;', '&', $code), $m);

            if (!empty($m[0])) {
                foreach ($m[0] as $k => $v) {
                    $import_url = $m[1][$k];

                    if (!empty($import_url)) {
                        $import_content = $this->_getImportContent($import_url);

                        if (!empty($import_content)) {
                            $code = str_replace($m[0][$k], $import_content, $code);
                        }
                    }
                }
            }
        }
    }

    /**
     * @param string $code
     * @return string
     */
    protected function collectCharsets(&$code)
    {
        return $this->_collect($code, '|\@charset[^;]+|is', function ($string) {
            return $string . ';';
        });
    }

    /**
     * @param string $code
     * @return string
     */
    protected function collectImports(&$code)
    {
        return $this->_collect($code, '|\@import[^;]+|is', function ($string) {
            return $string . ';';
        });
    }

    /**
     * @param string $code
     * @return string
     */
    protected function collectFonts(&$code)
    {
        return $this->_collect($code, '|\@font-face\{[^}]+\}|is', function ($string) {
            return $string;
        });
    }

    /**
     * @param string $code
     * @param string $pattern
     * @param callable $handler
     * @return string
     */
    protected function _collect(&$code, $pattern, $handler)
    {
        $result = '';

        preg_match_all($pattern, $code, $m);

        foreach ($m[0] as $string) {
            $string = $handler($string);
            $code = str_replace($string, '', $code);

            $result .= $string . PHP_EOL;
        }

        return $result;
    }

    /**
     * @param string $url
     * @return null|string
     */
    protected function _getImportContent($url)
    {
        $result = null;

        if ('url(' === mb_substr($url, 0, 4)) {
            $url = str_replace(['url(\'', 'url("', 'url(', '\')', '")', ')'], '', $url);

            if (mb_substr($url, 0, 2) === '//') {
                $url = preg_replace('|^//|', 'http://', $url, 1);
            }

            if (!empty($url)) {
                if (!in_array(mb_substr($url, 0, 4), ['http', 'ftp:'], true)) {
                    $url = \Yii::getAlias($this->view->basePath . $url);
                }

                $context = [
                    'ssl' => [
                        'verify_peer'      => false,
                        'verify_peer_name' => false,
                    ],
                ];

                $result = file_get_contents($url, null, stream_context_create($context));
            }
        }

        return $result;
    }
}
