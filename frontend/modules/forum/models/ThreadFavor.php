<?php

namespace app\modules\forum\models;

use Yii;

/**
 * This is the model class for table "{{%thread_favor}}".
 *
 * @property integer $id
 * @property integer $thread_id
 * @property string $thread_title
 * @property string $thread_content
 * @property integer $user_id
 */
class ThreadFavor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%thread_favor}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thread_id', 'thread_title', 'thread_content', 'user_id'], 'required'],
            [['thread_id', 'user_id'], 'integer'],
            [['thread_content'], 'string'],
            [['thread_title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'thread_id' => 'Thread ID',
            'thread_title' => 'Thread Title',
            'thread_content' => 'Thread Content',
            'user_id' => 'User ID',
        ];
    }
}
