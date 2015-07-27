<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%explore_recommend}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $summary
 * @property string $content
 * @property integer $user_id
 * @property string $origin
 * @property string $username
 * @property string $category
 * @property integer $table_id
 * @property string $table_name
 * @property integer $created_at
 */
class ExploreRecommend extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%explore_recommend}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['title', 'summary', 'content', 'user_id', 'username', 'category', 'table_id', 'table_name', 'created_at'], 'required'],
            [['summary', 'content', 'origin'], 'string'],
            [['user_id', 'created_at'], 'integer'],
            [['title', 'username'], 'string', 'max' => 128],
            [['category'], 'string', 'max' => 50],
            [['table_name', 'table_id'], 'string', 'max' => 30]
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
            'summary' => Yii::t('app', 'Summary'),
            'content' => Yii::t('app', 'Content'),
            'user_id' => Yii::t('app', 'User ID'),
            'username' => Yii::t('app', 'Username'),
            'category' => Yii::t('app', 'Category'),
            'table_id' => Yii::t('app', 'Table ID'),
            'table_name' => Yii::t('app', 'Table Name'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }
}
