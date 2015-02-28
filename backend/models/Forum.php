<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%forum}}".
 *
 * @property integer $id
 * @property string $forum_name
 * @property string $forum_desc
 * @property string $forum_url
 * @property integer $user_id
 * @property integer $create_time
 * @property string $forum_icon
 * @property string $theme
 * @property string $layout
 *
 * @property ForumBoard[] $forumBoards
 */
class Forum extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%forum}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['forum_name', 'forum_desc', 'forum_url', 'user_id', 'create_time', 'forum_icon', 'theme', 'layout'], 'required'],
            [['forum_desc'], 'string'],
            [['user_id', 'create_time'], 'integer'],
            [['forum_name', 'forum_url'], 'string', 'max' => 32],
            [['forum_icon'], 'string', 'max' => 26],
            [['theme', 'layout'], 'string', 'max' => 9]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'forum_name' => Yii::t('app', 'Forum Name'),
            'forum_desc' => Yii::t('app', 'Forum Desc'),
            'forum_url' => Yii::t('app', 'Forum Url'),
            'user_id' => Yii::t('app', 'User ID'),
            'create_time' => Yii::t('app', 'Create Time'),
            'forum_icon' => Yii::t('app', 'Forum Icon'),
            'theme' => Yii::t('app', 'Theme'),
            'layout' => Yii::t('app', 'Layout'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForumBoards()
    {
        return $this->hasMany(ForumBoard::className(), ['forum_id' => 'id']);
    }
}
