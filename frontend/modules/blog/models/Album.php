<?php

namespace app\modules\blog\models;

use Yii;

/**
 * This is the model class for table "{{%blog_album}}".
 *
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $cover_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $enable_comment
 * @property integer $privilege_type
 * @property string $privilege_password
 * @property string $privilege_question
 * @property string $privilege_answer
 */
class Album extends \yii\db\ActiveRecord
{
    const TYPE_PUBLIC = 0;
    const TYPE_PASSWORD = 1;
    const TYPE_QUESTION = 2;
    const TYPE_PRIVATE = 3;

    const COVER_NONE = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%blog_album}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['cover_id', 'created_at', 'updated_at', 'created_by', 'enable_comment', 'privilege_type'], 'integer'],
            [['privilege_password', 'privilege_question', 'privilege_answer'], 'string'],
            [['name', 'description'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'cover_id' => Yii::t('app', 'Cover ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'enable_comment' => Yii::t('app', 'Enable Comment'),
            'privilege_type' => Yii::t('app', 'Privilege Setting'),
            'privilege_password' => Yii::t('app', 'Password'),
            'privilege_question' => Yii::t('app', 'Question'),
            'privilege_answer' => Yii::t('app', 'Answer'),
        ];
    }

    public function getPhotoCount()
    {
        return Yii::$app->db
            ->createCommand("SELECT count(*) FROM {{%blog_photo}}  WHERE album_id={$this->id}")
            ->queryScalar();
    }

    /**
     * This is invoked before the record is saved.
     * @return boolean whether the record should be saved.
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->created_by = Yii::$app->user->identity->id;
                $this->created_at = time();
                $this->updated_at = time();
                $this->cover_id = self::COVER_NONE;
            }
            return true;
        } else {
            return false;
        }
    }

    public function getPhotos()
    {
        return Yii::$app->db
            ->createCommand("SELECT name, path, id FROM {{%blog_photo}} WHERE album_id={$this->id}")
            ->queryAll();
    }

    public function getUser()
    {
        return Yii::$app->db
            ->createCommand("SELECT username, avatar FROM {{%user}} WHERE id={$this->created_by}")
            ->queryOne();
    }

    /**
     * 取得封面图片的地址
     * 本来只要一个相册id也是可以的，但为减少查询，故同时要 $id, $cover_id
     * @param integer $id 相册id
     * @param integer $cover_id 封面id
     */
    public static function getCoverPhoto($id = null, $cover_id = null)
    {
        if ($id == null) {
            if ($this->cover_id == self::COVER_NONE) {
                if ($this->photoCount == 0) {
                    return '/images/pic-none.png';
                } else {
                    $path = $this->photos[0]['path'];
                }
            } else {
                $path = Yii::$app->db
                ->createCommand('SELECT path FROM {{%blog_photo}} WHERE id='.$this->cover_id)
                ->queryScalar();
            }
        } else {
            if ($cover_id == self::COVER_NONE) {
                $path = Yii::$app->db
                    ->createCommand('SELECT path FROM {{%blog_photo}} WHERE album_id='.$id)
                    ->queryScalar();
                if (empty($path)) {
                    return '/images/pic-none.png';
                }
            } else {
                $path = Yii::$app->db
                    ->createCommand('SELECT path FROM {{%blog_photo}} WHERE id='.$cover_id)
                    ->queryScalar();
            }
        }
        return Yii::getAlias('@photo').$path;
    }
}
