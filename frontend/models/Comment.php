<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%comment}}".
 *
 * @property string $id
 * @property integer $table_id
 * @property string $table_name
 * @property string $content
 * @property string $parent_id
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
            ['content', 'required'],
            [['id', 'table_id', 'parent_id', 'user_id', 'created_at'], 'integer'],
            [['content'], 'string'],
            [['table_name'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'table_name' => Yii::t('app', 'Table Name'),
            'content' => Yii::t('app', 'Content'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'created_at' => Yii::t('app', 'Created At'),
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
                $this->user_id = Yii::$app->user->id;
                $this->created_at = time();
            }
            return true;
        } else {
            return false;
        }
    }
}
