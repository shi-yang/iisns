<?php
/**
 * @link http://www.iisns.com/
 * @copyright Copyright (c) 2015 iiSNS
 * @license http://www.iisns.com/license/
 */

namespace app\modules\user\models;

use Yii;

/**
 * This is the model class for table "{{%user_follow}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $people_id
 *
 * @property User $user
 * @property User $people
 *
 * @author Shiyang <dr@shiyang.me>
 * @since 2.0
 */
class UserFollow extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_follow}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'people_id'], 'required'],
            [['user_id', 'people_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'people_id' => Yii::t('app', 'People ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPeople()
    {
        return $this->hasOne(User::className(), ['id' => 'people_id']);
    }
}
