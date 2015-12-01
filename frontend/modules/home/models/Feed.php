<?php
/**
 * @link http://www.iisns.com/
 * @copyright Copyright (c) 2015 iiSNS
 * @license http://www.iisns.com/license/
 */

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
 *
 * @author Shiyang <dr@shiyang.me>
 * @since 2.0
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
            [['content'], 'required', 'on' => ['create']],
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
                $this->type = 'post';
                $this->user_id = Yii::$app->user->id;
                $this->created_at = time();
            }
           return true;
       } else {
              return false;
       }
    }

    public function scenarios()
    {
        return [
            'create' => ['content'],
            'repost'
        ];
    }

    /**
     * 增加记录
     * @param string $type 记录的类型，发布日志、相册、音乐、视频等
     * @param array $data 内容，序列化保存
     */
    public static function addFeed($type, $data){
        $setarr = [];
        switch ($type) {
            //发表日志
            case 'blog':
                $setarr['type'] = 'postblog';
                $setarr['template'] = '<b>{title}</b><br>{content}';
                break;
            //转发
            case 'repost':
                $setarr['type'] = 'repost';
                if (empty($data['{comment}'])) {
                    array_shift($data);
                    $comment = '';
                } else {
                    $comment = '{comment}<br>';
                }

                if (empty($data['{content}'])) {
                    array_shift($data);
                    $data['{feed_data}'] = array_merge(['{username}' => $data['{username}']], $data['{feed_data}']);
                    $setarr['template'] = '<b>{username}</b>：' . $data['{template}'];
                    $data = $data['{feed_data}'];
                } else {
                    $setarr['template'] = '<b>{username}</b>：{content}';
                }
                $setarr['template'] .= $comment;
                break;
            case 'album':
            case 'video':
                break;
        }
        $setarr['feed_data'] = serialize($data);
        $setarr['user_id'] = Yii::$app->user->id;
        $setarr['created_at'] = time();
        Yii::$app->userData->updateKey('feed_count', Yii::$app->user->id);
        return Yii::$app->db->createCommand()->insert('{{%home_feed}}', $setarr)->execute();
    }
}
