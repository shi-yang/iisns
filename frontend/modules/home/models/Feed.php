<?php

namespace app\modules\home\models;

use Yii;

/**
 * This is the model class for table "{{%home_feed}}".
 *
 * @property integer $id
 * @property string $type
 * @property string $content
 * @property string $template
 * @property integer $comment_count
 * @property integer $repost_count
 * @property integer $feed_data
 * @property integer $user_id
 * @property integer $created_at
 */
class Feed extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%home_feed}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'required'],
            [['id', 'comment_count', 'repost_count', 'feed_data', 'created_at', 'user_id'], 'integer'],
            [['content'], 'string', 'max' => 140],
            [['type'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', 'Type'),
            'content' => Yii::t('app', 'Content'),
            'comment_count' => Yii::t('app', 'Comment Count'),
            'repost_count' => Yii::t('app', 'Repost Count'),
            'feed_data' => Yii::t('app', 'Feed Data'),
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

    public static function addFeed($type, $data){
        $setarr = [];
        switch ($type) {
            //发表日志
            case 'post':
                $setarr['template'] = '<b>{title}</b><br>{summary}';
                $setarr['feed_data'] = $data;
                $setarr['user_id'] = Yii::$app->user->id;
                $setarr['created_at'] = time();
                Yii::$app->db->createCommand()->insert('{{%home_feed}}', $setarr)->execute();
                break;
            case 'album':
                ;
                break;
        }
    }
}
