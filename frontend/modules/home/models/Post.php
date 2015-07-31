<?php

namespace app\modules\home\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%home_post}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $tags
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $user_id
 */
class Post extends \yii\db\ActiveRecord
{
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
            [['title', 'content'], 'required'],
            [['content', 'tags'], 'string'],
            [['created_at', 'updated_at', 'user_id'], 'integer'],
            [['title'], 'string', 'max' => 80]
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
            'created_at' => Yii::t('app', 'Create Time'),
            'updated_at' => Yii::t('app', 'Update Time'),
            'user_id' => Yii::t('app', 'User ID'),
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
            //标签分割
            $tags = trim($this->tags);
            $explodeTags = array_unique(explode(',', str_replace('，', ',', $tags)));
            $explodeTags = array_slice($explodeTags, 0, 10);
            $this->tags = implode(',', $explodeTags);
            return true;
        } else {
            return false;
        }
    }

    /**
     *string the URL that shows the detail of the post
     */
    public function getUrl()
    {       
        return Url::toRoute(['/user/view/post-view', 'id' => $this->id]);
    }

    public function getUser()
    {
        return Yii::$app->db->createCommand("SELECT id, avatar, email, username FROM {{%user}} WHERE id={$this->user_id}")->queryOne();
    }

    public function getUserProfile()
    {
        return Yii::$app->db->createCommand("SELECT * FROM {{%user_profile}} WHERE user_id={$this->user_id}")->queryOne();
    }

    public function getUserData()
    {
        return Yii::$app->db->createCommand("SELECT * FROM {{%user_data}} WHERE user_id={$this->user_id}")->queryOne();
    }
}
