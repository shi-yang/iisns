<?php
/**
 * @link http://www.iisns.com/
 * @copyright Copyright (c) 2015 iiSNS
 * @license http://www.iisns.com/license/
 */

namespace app\modules\forum\models;

use Yii;

/**
 * This is the model class for table "{{%forum_broadcast}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property integer $forum_id
 * @property integer $user_id
 * @property integer $thread_id
 * @property integer $created_at
 *
 * @author Shiyang <dr@shiyang.me>
 * @since 2.0
 */
class Broadcast extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%forum_broadcast}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'required'],
            [['content'], 'string'],
            [['thread_id', 'forum_id', 'user_id', 'created_at'], 'integer'],
            [['title'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'content' => Yii::t('app', 'Content'),
            'forum_id' => Yii::t('app', 'Forum ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'created_at' => Yii::t('app', 'Create Time'),
        ];
    }

    /**
     * This is invoked before the record is saved.
     * @return boolean whether the record should be saved.
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
	        if ($this->isNewRecord) {
    	        $this->user_id = Yii::$app->user->identity->id;
    	        $this->created_at = time();
	        }
            return true;
        } else {
            return false;
        }
    }
}
