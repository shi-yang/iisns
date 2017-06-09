<?php
/**
 * @link http://www.iisns.com/
 * @copyright Copyright (c) 2015 iiSNS
 * @license http://www.iisns.com/license/
 */

namespace app\modules\home\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\Markdown;

/**
 * This is the model class for table "{{%home_post}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $markdown
 * @property string $tags
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $user_id
 * @property string $status
 * @property integer $explore_status
 *
 * @author Shiyang <dr@shiyang.me>
 */
class Post extends ActiveRecord
{
    const STATUS_PUBLIC = 'public';
    const STATUS_PRIVATE = 'private';
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
            [['title'], 'required'],
            [['content', 'tags', 'status', 'markdown'], 'string'],
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
            'status' => Yii::t('app', 'Status')
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

                if ($this->status == Post::STATUS_PUBLIC) {
                    //插入记录(Feed)
                    $title = Html::a(Html::encode($this->title), $this->url);
                    preg_match_all("/<[img|IMG].*?src=\"([^^]*?)\".*?>/", $this->content, $images);
                    $images = (isset($images[0][0])) ? $images[0][0] : '' ;
                    $content = mb_substr(strip_tags($this->content), 0, 140, 'utf-8') . '... ' . Html::a(Yii::t('app', 'View Details'), $this->url) . '<br>' . $images;
                    $postData = ['{title}' => $title, '{content}' => $content];
                    Feed::addFeed('blog', $postData);
                }

                Yii::$app->userData->updateKey('post_count', Yii::$app->user->id);
            }
            //标签分割
            $tags = trim($this->tags);
            $explodeTags = array_unique(explode(',', str_replace('，', ',', $tags)));
            $explodeTags = array_slice($explodeTags, 0, 10);
            $this->tags = implode(',', $explodeTags);

            if (!empty($this->markdown)) {
                $this->content = Markdown::process($this->markdown, 'gfm');
            }
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
        return Url::toRoute(['/user/view/view-post', 'id' => $this->id]);
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
