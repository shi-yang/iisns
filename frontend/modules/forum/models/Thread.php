<?php
/**
 * @link http://www.iisns.com/
 * @copyright Copyright (c) 2015 iiSNS
 * @license http://www.iisns.com/license/
 */

namespace app\modules\forum\models;

use Yii;
use yii\helpers\Url;
use yii\db\Query;

/**
 * This is the model class for table "{{%forum_thread}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $user_id
 * @property integer $board_id
 * @property integer $post_count
 *
 * @author Shiyang <dr@shiyang.me>
 * @since 2.0
 */
class Thread extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%forum_thread}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['content'], 'string'],
            [['created_at', 'user_id', 'board_id', 'post_count', 'updated_at'], 'integer'],
            [['title'], 'string', 'min' => 2, 'max' => 80],
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
            'created_at' => Yii::t('app', 'Create Time'),
            'user_id' => Yii::t('app', 'User ID'),
            'board_id' => Yii::t('app', 'Block ID'),
            'post_count' => Yii::t('app', 'Post Count')
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
                $this->updated_at = time();
            }
            return true;
        } else {
            return false;
        }
    }
    
    /**
     *string the URL that shows the detail of the thread
     */
    public function getUrl()
    {
    	 return Url::toRoute(['/forum/thread/view', 'id' => $this->id]);
    }

    public function getUser()
    {
        return Yii::$app->db
            ->createCommand("SELECT id, username, avatar FROM {{%user}} WHERE id={$this->user_id}")
            ->queryOne();
    }
    
    public function getForum()
    {
        return Yii::$app->db
            ->createCommand("SELECT * FROM {{%forum}} as f JOIN {{%forum_board}} as b ON f.id=b.forum_id WHERE b.id={$this->board_id}")
            ->queryOne();
    }
    
    public function getBoard()
    {
        return Yii::$app->db
            ->createCommand("SELECT id, name, user_id FROM {{%forum_board}} WHERE id={$this->board_id}")
            ->queryOne();
    }
    
    public function isFavor()
    {
        $query = new Query;
        return $query->select('id')
		  ->from('{{%post_favor}}')
		  ->where('post_id=:id and user_id=:user_id', [':id'=>$this->id, ':user_id'=>Yii::$app->user->id])
          ->exists();
    }

    public function isOneBoard()
    {
        $forum_id = $this->forum['forum_id'];
        $count = Yii::$app->db
            ->createCommand("SELECT count(*) FROM {{%forum_board}} WHERE forum_id={$forum_id}")
            ->queryScalar();
        return ($count == 1) ? true : false;
    }

    /**
     * 获取回复的帖子
     * @return array
     */
    public function getPosts()
    {
        $query = new Query;
        $query->select('p.id,  p.content, p.created_at, p.user_id, u.username, u.avatar')
            ->from('{{%forum_post}} as p')
            ->join('LEFT JOIN','{{%user}} as u', 'u.id=p.user_id')
            ->where('p.thread_id=:id', [':id' => $this->id]);
        $result = Yii::$app->tools->Pagination($query);
        return ['posts' => $result['result'], 'pages' => $result['pages']];
    }

    /**
     * 获取SEO信息，标题，关键字，描述
     * @return array ['title', 'keywords', 'description']
     */
    public function getSeoInfo()
    {
        $data = strip_tags($this->content);
        $title = (empty($this->title)) ? mb_substr($data, 0, 80) : $this->title;
        $description = mb_substr($data, 0, 200, 'utf-8');
        $keywords = $title;
        return [
            'title' => $title,
            'keywords' => $keywords,
            'description' => $description
        ];
    }
}
