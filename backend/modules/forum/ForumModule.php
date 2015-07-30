<?php

namespace backend\modules\forum;

use Yii;

class ForumModule extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\forum\controllers';

    public function init()
    {
        parent::init();

        if (!isset(Yii::$app->i18n->translations['forum'])) {
            Yii::$app->i18n->translations['forum'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en',
                'basePath' => '@backend/modules/forum/messages'
            ];
        }
    }
}
