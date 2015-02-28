<?php

namespace backend\modules\install\models;

use yii\base\Model;
use Yii;
use yii\db\Connection;

class AdminForm extends Model
{

    public $name;
    public $password;
    public $email;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'password', 'email'], 'required'],
            ['password', 'string', 'min' => 6],
            ['email', 'email']
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => Yii::t('install', 'administrator name'),
            'password' => Yii::t('install', 'password'),
        ];
    }

    public function set()
    {
        Yii::$app->session->set('admin', $this->attributes);
    }

}
