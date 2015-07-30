<?php

namespace app\modules\user;

use Yii;

class UserModule extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\user\controllers';

    public function init()
    {
        parent::init();

        Yii::$app->i18n->translations['notice'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en',
            'basePath' => '@app/modules/user/messages'
        ];
    }
}
