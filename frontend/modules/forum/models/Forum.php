<?php
/**
 * @link http://www.iisns.com/
 * @copyright Copyright (c) 2015 iiSNS
 * @license http://www.iisns.com/license/
 */

namespace app\modules\forum\models;

use Yii;
use app\modules\forum\models\Board;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%forum}}".
 *
 * @property integer $id
 * @property string $forum_name
 * @property string $forum_desc
 * @property string $forum_url
 * @property integer $user_id
 * @property integer $created_at
 * @property integer $status
 * @property string $forum_icon
 *
 * @author Shiyang <dr@shiyang.me>
 * @since 2.0
 */
class Forum extends \yii\db\ActiveRecord
{
    const STATUS_PENDING = 0;
    const STATUS_APPROVED = 1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%forum}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['forum_name', 'forum_desc', 'forum_url'], 'required'],
            [['forum_url', 'forum_name'], 'unique'],
            [['forum_url'], 'string', 'min' => 5, 'max' => 32],
            [['forum_url'], 'match', 'pattern' => '/^(?!_)(?!.*?_$)(?!\d{5,32}$)[a-z\d_]{5,32}$/i'],
            [['forum_desc'], 'string'],
            [['user_id', 'created_at', 'status'], 'integer'],
            [['forum_name'], 'string', 'max' => 32],
            [['forum_url'], 'string', 'min' => 5, 'max' => 32],
            [['forum_icon'], 'file', 'extensions' => 'jpg, png', 'mimeTypes' => 'image/jpeg, image/png',],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'forum_name' => Yii::t('app', 'Forum Name'),
            'forum_desc' => Yii::t('app', 'Forum Description'),
            'forum_url' => Yii::t('app', 'Forum Url'),
            'user_id' => Yii::t('app', 'User ID'),
            'created_at' => Yii::t('app', 'Create Time'),
            'status' => Yii::t('app', 'Status'),
            'forum_icon' => Yii::t('app', 'Forum Icon'),
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
                $this->user_id = Yii::$app->user->identity->id;
                $this->created_at = time();
                $this->forum_icon = 'default/' . rand(1, 11) . '.png';
                $this->status = Forum::STATUS_PENDING;
            }
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * 统计当前论坛下的板块总数
     */
    public function getBoardCount()
    {
        return Yii::$app->db
            ->createCommand("SELECT count(*) FROM {{%forum_board}} WHERE forum_id={$this->id}")
            ->queryScalar();
    }
    
    /**
     * @return yii\db\ActiveQuery
     */
    public function getBoards()
    {
        return Board::find()->where(
            'forum_id = :forum_id && (parent_id = :BOARD || parent_id = :CATEGORY)', 
            [':forum_id' => $this->id, ':BOARD' => Board::AS_BOARD, ':CATEGORY' => Board::AS_CATEGORY]
        )->all();
    }

    /**
     * @return boolean whether the user follow the forum
     */
    public function isFollow()
    {
        $query = new Query;
        return $query->select('id')
                ->from('{{%forum_follow}}')
                ->where('forum_id=:id and user_id=:user_id', [':id'=>$this->id, ':user_id'=>Yii::app()->user->id])
                ->exists();
    }

    public function getFollowerCount()
    {
        return Yii::$app->db
            ->createCommand("SELECT count(*) FROM {{%forum_follow}} WHERE forum_id={$this->id}")
            ->queryScalar();
    }

    public function getThreadCount()
    {
        $query = new Query;
        $query->select('count(*) as num')
            ->from('{{%forum_thread}}'.' p')
            ->join('JOIN', '{{%forum_board}}' .' b', 'b.id=p.board_id')
            ->where('b.forum_id=:id', array(':id'=>$this->id));
        return $query->scalar();
    }
    
    /**
     * @return array the array representation of the object
     */
    public function getToArray()
    {
        return ArrayHelper::toArray($this);
    }
    
    public function getBroadcasts()
    {
        $query = new Query;
        $query = $query->select('*')
            ->from('{{%forum_broadcast}}' . ' p')
            ->where('forum_id=:forum_id', [':forum_id' => $this->id])
            ->orderBy('created_at DESC');
            
        return Yii::$app->tools->Pagination($query);
    }

    public function getBroadcastCount()
    {
        return Yii::$app->db
            ->createCommand('SELECT count(*) FROM {{%forum_broadcast}} WHERE forum_id='. $this->id)
            ->queryScalar();
    }
}
