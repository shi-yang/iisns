<?php
/**
 * @link http://www.iisns.com/
 * @copyright Copyright (c) 2015 iiSNS
 * @license http://www.iisns.com/license/
 */

namespace app\modules\forum\models;

use Yii;
use app\modules\forum\models\Thread;
use yii\helpers\Url;
use yii\db\Query;

/**
 * This is the model class for table "pre_forum_board".
 *
 * @property integer $id
 * @property string $name
 * @property integer $parent_id
 * @property string $description
 * @property integer $forum_id
 * @property integer $columns
 * @property integer $user_id
 *
 * @author Shiyang <dr@shiyang.me>
 */
class Board extends \yii\db\ActiveRecord
{
    const AS_CATEGORY = 0;
    const AS_BOARD = 1;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%forum_board}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description'], 'string'],
            [['parent_id', 'forum_id', 'user_id', 'columns'], 'integer'],
            [['name'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent_id' => Yii::t('app', 'Parent'),
            'name' => Yii::t('app', 'Board Name'),
            'description' => Yii::t('app', 'Board Description'),
            'columns' => Yii::t('app', 'Sub Board Column'),
            'forum_id' => Yii::t('app', 'Forum ID'),
            'user_id' => Yii::t('app', 'User ID'),
        ];
    }
    
    /**
        *string the URL that shows the detail of the forumblock
        */
    public function getUrl()
    {        
        return Url::toRoute(['/forum/board/view', 'id' => $this->id]);
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
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return array
     */
    public function getForum()
    {
        return Yii::$app->db
            ->createCommand("SELECT forum_url,forum_name,user_id FROM {{%forum}} WHERE id={$this->forum_id}")
            ->queryOne();
    }
    
    public function isOneBoard()
    {
        $boardCount = Yii::$app->db
            ->createCommand("SELECT count(*) as num FROM {{%forum_board}} `b` JOIN {{%forum}} `f` ON f.id=b.forum_id WHERE f.id={$this->forum_id}")
            ->queryScalar();
        return ($boardCount == 1) ? true : false;
    }

    /**
     * 获取话题
     * @return array
     */
    public function getThreads()
    {
        $query = new Query;
        $query->select('t.id, t.title, t.content, t.updated_at, t.user_id, t.post_count, u.username, u.avatar')
            ->from('{{%forum_thread}} as t')
            ->join('LEFT JOIN','{{%user}} as u', 'u.id=t.user_id')
            ->where('t.board_id=:id', [':id' => $this->id])
            ->orderBy('t.updated_at DESC');
        $result = Yii::$app->tools->Pagination($query);
        return ['threads' => $result['result'], 'pages' => $result['pages']];
    }
    
    public static function getThreadCount($id = null)
    {
        if ($id != null) {
            return Yii::$app->db
                ->createCommand("SELECT count(*) FROM {{%forum_thread}}  WHERE board_id={$id}")
                ->queryScalar();
        }
        return ;
    }
    
    /**
     * 取得当前版块下最新的一条消息的发布作者，发布时间
     * @param integer $id 板块id
     */
    public static function getLastThread($id)
    {
        $query = new Query;
        $thread = $query->select('u.username, t.updated_at')
            ->from('{{%forum_board}} as t')
            ->join('LEFT JOIN','{{%user}} as u', 'u.id=t.updated_by')
            ->where('t.id=:id', [':id'=>$id])
            ->one();
        return [
            'username' => $thread['username'],
            'created_at'=>$thread['updated_at'],
        ];
    }

    /**
     * 取得当前版块下的子版块
     * @return array
     */
    public function getSubBoards()
    {
        return Yii::$app->db
            ->createCommand("SELECT * FROM {{%forum_board}}  WHERE parent_id={$this->id}")
            ->queryAll();
    }
}
