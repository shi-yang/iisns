<?php

namespace backend\modules\install\models;

use yii\base\Model;
use Yii;
use yii\db\Connection;

class MailForm extends Model
{

    public $host;
    public $name;
    public $password;
    public $port;
    public $encryption;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['host', 'name', 'password'], 'required'],
            [['encryption', 'port'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'host' => Yii::t('install', 'host'),
            'name' => Yii::t('install', 'username'),
            'password' => Yii::t('install', 'password'),
            'port' => Yii::t('install', 'port'),
            'encryption' => Yii::t('install', 'encryption type')
        ];
    }

    public function set()
    {
        Yii::$app->session->set('admin', $this->attributes);
    }

}
