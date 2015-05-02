<?php

namespace app\modules\user\models;

use Yii;

/**
 * This is the model class for table "{{%user_data}}".
 *
 * @property integer $user_id
 * @property integer $post_count
 * @property integer $following_count
 * @property integer $follower_count
 * @property integer $unread_comment_count
 * @property integer $unread_message_count
 */
class UserData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_data}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_count', 'following_count', 'follower_count', 'unread_comment_count', 'unread_message_count'], 'required'],
            [['post_count', 'following_count', 'follower_count', 'unread_comment_count', 'unread_message_count'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('app', 'User ID'),
            'post_count' => Yii::t('app', 'Post Count'),
            'following_count' => Yii::t('app', 'Following Count'),
            'follower_count' => Yii::t('app', 'Follower Count'),
            'unread_comment_count' => Yii::t('app', 'Unread Comment Count'),
            'unread_message_count' => Yii::t('app', 'Unread Message Count'),
        ];
    }

    /**
     * 获取某个用户的指定Key值的统计数目
     * Key值：
     * post_count：微博总数
     * following_count：关注数
     * follower_count：粉丝数
     * unread_comment_count：评论未读数
     * unread_message_count：未读消息
     * @param boolean $all 取得所有的数据
     * @param string $key Key值
     * @param integer $userId 用户id 默认为当前登录的用户
     * @return integer
     */
    public function getKey($all, $key = null, $userId = null)
    {
        $userId = ($userId === null) ? Yii::$app->user->id : $userId ;
        if ($all == true) {
            return Yii::$app->db->createCommand('SELECT * FROM {{%user_data}} WHERE user_id='.$userId)->queryOne();
        }
        return Yii::$app->db->createCommand("SELECT $key FROM {{%user_data}} WHERE user_id=$userId")->queryScalar();
    }

    /**
     * 更新某个用户的指定Key值的统计数目
     * Key值：
     * post_count：微博总数
     * following_count：关注数
     * follower_count：粉丝数
     * unread_comment_count：评论未读数
     * unread_message_count：未读消息
     * @param string $key Key值
     * @param integer $userId 用户id
     * @param integer $nums 更新的数目，默认为 1
     * @param integer $add  是增加还是设置为
     * @return boolean
     */
    public function updateKey($key, $userId, $nums = 1, $add = true)
    {
        switch ($key) {
            case 'post_count':
            case 'following_count':
            case 'follower_count':
            case 'unread_comment_count':
            case 'unread_message_count':
                break;
            default:
                return false;
                break;
        }
        if ($add) {
            return Yii::$app->db->createCommand("UPDATE {{%user_data}} SET {$key}={$key}+{$nums} WHERE user_id=".$userId)->execute();
        } else {
            return Yii::$app->db->createCommand("UPDATE {{%user_data}} SET {$key}={$nums} WHERE user_id=".$userId)->execute();
        }
    }
}
