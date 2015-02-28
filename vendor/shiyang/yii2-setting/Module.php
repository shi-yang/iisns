<?php
/**
 * @copyright Copyright (c) 2015 Shiyang
 * @author Shiyang <dr@shiyang.me>
 * @link http://shiyang.me
 * @license http://opensource.org/licenses/MIT
 */

namespace shiyang\setting;
use Yii;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'shiyang\setting\controllers\backend';

    public function init()
    {
        parent::init();
        $this->registerTranslations();
        $this->setViewPath('@shiyang/setting/views');
    }

    /**
     * Registers the translation files
     */
    protected function registerTranslations()
    {
        Yii::$app->i18n->translations['extensions/yii2-setting/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@vendor/shiyang/yii2-setting/messages',
            'fileMap' => [
                'extensions/yii2-setting/setting' => 'setting.php',
            ],
        ];
    }

    /**
     * Translates a message. This is just a wrapper of Yii::t
     *
     * @see Yii::t
     *
     * @param $category
     * @param $message
     * @param array $params
     * @param null $language
     * @return string
     */
    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('extensions/yii2-setting/' . $category, $message, $params, $language);
    }
}
