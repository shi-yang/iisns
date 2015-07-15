<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%comment}}".
 *
 * @property string $id
 * @property string $table
 * @property string $content
 * @property string $parent_id
 * @property integer $floor
 * @property integer $user_id
 * @property integer $created_at
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%comment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'table', 'content', 'parent_id', 'floor', 'user_id', 'created_at'], 'required'],
            [['id', 'parent_id', 'floor', 'user_id', 'created_at'], 'integer'],
            [['content'], 'string'],
            [['table'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'table' => Yii::t('app', 'Table'),
            'content' => Yii::t('app', 'Content'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'floor' => Yii::t('app', 'Floor'),
            'user_id' => Yii::t('app', 'User ID'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }
}
