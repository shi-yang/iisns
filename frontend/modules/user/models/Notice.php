<?php
/**
 * @link http://www.iisns.com/
 * @copyright Copyright (c) 2015 iiSNS
 * @license http://www.iisns.com/license/
 */

namespace app\modules\user\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "{{%user_notice}}".
 *
 * @property integer $id
 * @property string $type
 * @property string $title
 * @property string $content
 * @property integer $from_user_id
 * @property integer $to_user_id
 * @property integer $created_at
 * @property integer $is_read
 *
 * @author Shiyang <dr@shiyang.me>
 */
class Notice extends \yii\db\ActiveRecord
{
    /**
     * 消息已读未读状态
     */
    const READ_STATUS_YES = 1;
    const READ_STATUS_NO = 0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_notice}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'content', 'from_user_id', 'to_user_id', 'created_at', 'is_read'], 'required'],
            [['content'], 'string'],
            [['from_user_id', 'to_user_id', 'created_at', 'is_read'], 'integer'],
            [['type'], 'string', 'max' => 50],
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('notice', 'ID'),
            'type' => Yii::t('notice', 'Type'),
            'title' => Yii::t('notice', 'Title'),
            'content' => Yii::t('notice', 'Content'),
            'from_user_id' => Yii::t('notice', 'From User ID'),
            'to_user_id' => Yii::t('notice', 'To User ID'),
            'created_at' => Yii::t('notice', 'Created At'),
            'is_read' => Yii::t('notice', 'Is Read'),
        ];
    }

    /**
     * 给用户发送通知
     * @param string $type 通知类型
     * @param array $title 标题
     * @param string $content 内容
     * @param array $sourceUrl 来源Url
     * @param integer $toUserId 发送给用户的用户ID
     * @param integer $fromUserId 由哪个用户ID发来的，为空则为当前登录用户
     */
    public static function sendNotice($type, $title, $content, $sourceUrl, $toUserId, $fromUserId = null)
    {
        if (($typeInfo = NoticeType::getTypeInfo($type)) === null) {
            return false;
        }
        $fromUserId = ($fromUserId === null) ? Yii::$app->user->id : $fromUserId ;
        return $query = Yii::$app->db->createCommand()->insert('{{%user_notice}}', [
            'type' => $type,
            'title' => serialize($title),
            'content' => $content,
            'source_url' => serialize($sourceUrl),
            'to_user_id' => $toUserId,
            'from_user_id' => $fromUserId,
            'created_at' => time(),
            'is_read' => self::READ_STATUS_NO
        ])->execute();
    }

    /**
     * 取得用户的所有消息通知
     * @param integer $id 用户ID，为空则取当前登录用户
     */
    public static function getAllNotice($id = null)
    {
        $id = ($id === null) ? Yii::$app->user->id : $id ;
        $query = (new Query)->select('u.username, u.avatar, t.type_title, n.title, n.content, n.source_url, n.created_at, n.is_read')
            ->from('{{%user_notice}} as n')
            ->where('to_user_id=:id', [':id' => $id])
            ->join('LEFT JOIN','{{%user}} as u', 'u.id=n.from_user_id')
            ->join('LEFT JOIN','{{%user_notice_type}} as t', 't.type=n.type')
            ->orderBy('n.id DESC');
        return Yii::$app->tools->Pagination($query);
    }
}
