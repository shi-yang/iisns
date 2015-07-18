<?php

namespace app\modules\home\models;

use Yii;

/**
 * This is the model class for table "{{%home_photo}}".
 *
 * @property string $id
 * @property string $album_id
 * @property string $name
 * @property string $thumb
 * @property string $path
 * @property string $store_name
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $is_cover
 */
class Photo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%home_photo}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['album_id', 'name', 'thumb', 'path', 'created_at', 'created_by'], 'required'],
            [['album_id', 'created_at', 'created_by', 'is_cover'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['thumb', 'path', 'store_name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'album_id' => Yii::t('app', 'Album ID'),
            'name' => Yii::t('app', 'Name'),
            'thumb' => Yii::t('app', 'Thumb'),
            'path' => Yii::t('app', 'Path'),
            'store_name' => Yii::t('app', 'Store Name'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'is_cover' => Yii::t('app', 'Is Cover'),
        ];
    }
}
