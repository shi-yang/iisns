<?php

namespace app\modules\forum\models;

use Yii;
use app\modules\user\models\User;
use app\modules\forum\models\Thread;
/**
 * This is the model class for table "forum_post".
 *
 * @property integer $id
 * @property string $content
 * @property integer $user_id
 * @property integer $thread_id
 * @property integer $create_time
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%forum_post}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'required'],
            [['content'], 'string'],
            [['user_id', 'thread_id', 'create_time'], 'integer']
        ];
    }
    
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'content' => Yii::t('app', 'Content'),
            'user_id' => Yii::t('app', 'User ID'),
            'thread_id' => Yii::t('app', 'Thread ID'),
            'create_time' => Yii::t('app', 'Create Time'),
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
            	$this->create_time = time();
            }
            return true;
        } else {
             return false;
        }
    }
    
    public function getUser()
    {
        return Yii::$app->db
            ->createCommand("SELECT * FROM {{%user}} WHERE id={$this->user_id}")
            ->queryOne();
    }
}
