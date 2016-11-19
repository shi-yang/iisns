<?php
/**
 * @link http://www.iisns.com/
 * @copyright Copyright (c) 2015 iiSNS
 * @license http://www.iisns.com/license/
 */

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\db\Query;
use app\modules\home\models\Album;
use justinvoelker\tagging\TaggingQuery;

/**
 * ContactForm is the model used by ExploreController.
 *
 * @author Shiyang <dr@shiyang.me>
 */
class Explore extends Model
{
    public static function getAllPhotos()
    {
        $query = (new Query())->select('a.id, a.name, p.path, u.username, u.avatar')
            ->from('{{%home_album}} as a')
            ->join('LEFT JOIN','{{%home_photo}} as p', 'p.album_id=a.id')
            ->join('LEFT JOIN','{{%user}} as u', 'a.created_by=u.id')
            ->where('a.status=:type', [':type' => Album::TYPE_PUBLIC])
            ->orderBy('a.id DESC');
        return Yii::$app->tools->Pagination($query, 25);
    }

    public static function getPostQuery()
    {
        return (new Query())->select('e.id, title, content, e.created_at, u.username, u.avatar')
            ->from('{{%home_post}} as e')
            ->join('LEFT JOIN','{{%user}} as u', 'u.id=e.user_id')
            ->where('e.explore_status=1')
            ->orderBy('e.id DESC');
    }

    public static function getPostTags()
    {
        return (new TaggingQuery())->select('tags')
            ->from('{{%home_post}}')
            ->where('explore_status=1')
            ->limit(10)
            ->displaySort(['freq' => SORT_DESC])
            ->getTags();
    }

    public static function getPostList()
    {
        return (new Query())->select('e.id, title, content, e.created_at, u.username, u.avatar')
            ->from('{{%home_post}} as e')
            ->join('LEFT JOIN','{{%user}} as u', 'u.id=e.user_id')
            ->where('e.explore_status=1')
            ->orderBy('e.id DESC');
    }

    public static function getCurrentUserForum()
    {
        if (!Yii::$app->user->isGuest) {
            $myForums = Yii::$app->db->createCommand('SELECT forum_url, forum_name, forum_icon, status FROM {{%forum}} WHERE user_id=' . Yii::$app->user->id)->queryAll();
        } else {
            $myForums = null;
        }
        return $myForums;
    }

    public static function getForumList()
    {
        $forums = (new Query())->select('forum_url,forum_name,forum_desc,forum_icon')
            ->from('{{%forum}}')
            ->where('status=1')
            ->orderBy('id DESC');
        return Yii::$app->tools->Pagination($forums);
    }
}
