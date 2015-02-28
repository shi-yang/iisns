<?php

namespace app\modules\user\models;

use Yii;

/**
 * This is the model class for table "{{%post_favor}}".
 *
 * @property integer $id
 * @property integer $post_id
 * @property string $post_title
 * @property string $post_content
 * @property integer $user_id
 */
class PostFavor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post_favor}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'post_title', 'post_content', 'user_id'], 'required'],
            [['post_id', 'user_id'], 'integer'],
            [['post_content'], 'string'],
            [['post_title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => 'Post ID',
            'post_title' => 'Post Title',
            'post_content' => 'Post Content',
            'user_id' => 'User ID',
        ];
    }
}
