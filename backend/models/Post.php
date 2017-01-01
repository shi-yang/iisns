<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%home_post}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $tags
 * @property integer $user_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 */
class Post extends \yii\db\ActiveRecord
{
    const EXPLORE_STATUS_PENDING = 0;
    const EXPLORE_STATUS_APPROVED = 1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%home_post}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'content', 'tags', 'user_id', 'created_at'], 'required'],
            [['content', 'tags'], 'string'],
            [['user_id', 'created_at', 'updated_at', 'explore_status'], 'integer'],
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
            'tags' => Yii::t('app', 'Tags'),
            'user_id' => Yii::t('app', 'User ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getStatus()
    {
        return ($this->explore_status === 0) ? 'PENDING' : 'APPROVED' ;
    }
}
