<?php

namespace app\modules\blog\models;

use Yii;

/**
 * This is the model class for table "{{%blog_comment}}".
 *
 * @property integer $id
 * @property string $content
 * @property integer $create_time
 * @property string $author
 * @property string $email
 * @property integer $post_id
 * @property integer $user_id
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%blog_comment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content', 'create_time', 'author', 'email', 'post_id', 'user_id'], 'required'],
            [['content'], 'string'],
            [['create_time', 'post_id', 'user_id'], 'integer'],
            [['author', 'email'], 'string', 'max' => 128]
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
            'create_time' => Yii::t('app', 'Create Time'),
            'author' => Yii::t('app', 'Author'),
            'email' => Yii::t('app', 'Email'),
            'post_id' => Yii::t('app', 'Post ID'),
            'user_id' => Yii::t('app', 'User ID'),
        ];
    }
}
