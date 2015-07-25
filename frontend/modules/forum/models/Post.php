<?php

namespace app\modules\forum\models;

use Yii;
use app\modules\user\models\User;
use app\modules\user\models\Notice;
use app\modules\forum\models\Thread;
/**
 * This is the model class for table "forum_post".
 *
 * @property integer $id
 * @property string $content
 * @property integer $user_id
 * @property integer $thread_id
 * @property integer $created_at
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%forum_post}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'required'],
            [['content'], 'string'],
            [['user_id', 'thread_id', 'created_at'], 'integer']
        ];
    }
    
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'content' => Yii::t('app', 'Content'),
            'user_id' => Yii::t('app', 'User ID'),
            'thread_id' => Yii::t('app', 'Thread ID'),
            'created_at' => Yii::t('app', 'Create Time'),
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

    /**
     * @param boolean $insert
     * @param array $changedAttributes
     * @return bool
     */
    public function afterSave($insert, $changedAttributes)
    {
        $this->PostCuntPlus();
        
        $connection = Yii::$app->db;
        $thread = $connection->createCommand('SELECT id, user_id, title FROM {{%forum_thread}} WHERE id=' . $this->thread_id)->queryOne();

        //给用户发回复或者@通知,回复自己的不通知
        if(Yii::$app->user->id != $thread['user_id']) {
            Notice::sendNotice('NEW_COMMENT', ['title' => $thread['title']], $this->content, ['/forum/thread/view', 'id' => $thread['id']], $thread['user_id'], $this->user_id);
            //添加未读消息数
            Yii::$app->userData->updateKey('unread_notice_count', $thread['user_id']);
        }

        //回复中提到其他人，通知其他人
        if (strstr($this->content, '@')) {
            preg_match_all('/@(.*?)\s/', $this->content, $match);
            if(isset($match[1]) && count($match[1]) > 0) {
                $notice_user = array_unique($match[1]);
                foreach ($notice_user as $v) {
                    $toUserId = $connection->createCommand('SELECT id FROM {{%user}} WHERE username=:name')->bindValue(':name', $v)->queryScalar();
                    if ($toUserId == $thread['user_id'] || $toUserId == Yii::$app->user->id || empty($toUserId)) {
                        continue;
                    }
                    Notice::sendNotice('MENTION_ME', ['title' => $thread['title']], $this->content, ['/forum/thread/view', 'id' => $thread['id']], $toUserId, $this->user_id);
                }
            }
        }

        return parent::afterSave($insert, $changedAttributes);
    }

    public function getUser()
    {
        return Yii::$app->db
            ->createCommand("SELECT * FROM {{%user}} WHERE id={$this->user_id}")
            ->queryOne();
    }

    /**
     * 回复时统计数目增加一
     */
    public function PostCuntPlus()
    {
        return Yii::$app->db->createCommand("UPDATE {{%forum_thread}} SET post_count=post_count+1 WHERE id=".$this->thread_id)->execute();
    }
}
