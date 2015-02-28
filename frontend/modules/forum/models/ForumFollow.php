<?php

namespace app\modules\forum\models;

use Yii;

/**
 * This is the model class for table "{{%forum_follow}}".
 *
 * @property integer $id
 * @property integer $forum_id
 * @property integer $user_id
 */
class ForumFollow extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%forum_follow}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['forum_id', 'user_id'], 'required'],
            [['forum_id', 'user_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'forum_id' => 'Forum ID',
            'user_id' => 'User ID',
        ];
    }
}
