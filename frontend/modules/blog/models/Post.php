<?php

namespace app\modules\blog\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%blog_post}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $tags
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $user_id
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%blog_post}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'required'],
            [['content', 'tags'], 'string'],
            [['create_time', 'update_time', 'user_id'], 'integer'],
            [['title'], 'string', 'max' => 128]
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
            'create_time' => Yii::t('app', 'Create Time'),
            'update_time' => Yii::t('app', 'Update Time'),
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
              $this->user_id = Yii::$app->user->identity->id;
              $this->create_time = time();
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
        return Url::toRoute(['/blog/post/view', 'id' => $this->id]);
    }

    public function getUser()
    {
        $connection = Yii::$app->db;
        $command = $connection->createCommand("SELECT avatar, email, username FROM {{%user}} WHERE id={$this->user_id}");
        $user = $command->queryOne();
        return $user;
    }

    public function getUserProfile()
    {
        $connection = Yii::$app->db;
        $command = $connection->createCommand("SELECT * FROM {{%user_profile}} WHERE user_id={$this->user_id}");
        return $command->queryOne();
    }

    public function getMainContent()
    {
/*        $content = mb_substr(strip_tags($this->content), 0, 200,"utf-8");
        $pattern="/<[img|IMG].*?src=\"([^^]*?)\".*?>/"; 
        preg_match_all($pattern,$this->content, $match);
        if (!empty($match[1][0])) {
            echo '<div class="pull-left">';
            echo \yii\helpers\Html::img($match[1][0], ['style'=>'width:161px;height:127px;']);
            echo '</div>';
            echo '<div class="pull-left" style="width: 440px;padding-left: 11px;">';
            echo $content;
            echo '</div>';
        } else {
            echo $content;
        }*/
    }

    public function getImgView()
    {
 /*       $pattern="/<[img|IMG].*?src=\"([^^]*?)\".*?>/"; 
        preg_match_all($pattern,$this->content, $match);
        if (!empty($match[1][0])) {
            echo '<div class="pull-left">';
            echo \yii\helpers\Html::img($match[1][0]);
            echo '</div>';
        }
        return;*/
    }
}
