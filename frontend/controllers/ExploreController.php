<?php
/**
 * @link http://www.iisns.com/
 * @copyright Copyright (c) 2015 iiSNS
 * @license http://www.iisns.com/license/
 */
 
namespace frontend\controllers;

use Yii;
use yii\db\Query;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use common\components\BaseController;
use app\modules\home\models\Album;
use justinvoelker\tagging\TaggingQuery;

Yii::setAlias('forum_icon', '@web/uploads/forum/icon/');
Yii::setAlias('avatar', '@web/uploads/user/avatar/');
Yii::setAlias('photo', '@web/uploads/home/photo/');

/**
 * Explore controller
 *
 * @author Shiyang <dr@shiyang.me>
 * @since 2.0
 */
class ExploreController extends BaseController
{
    public $layout = 'explore';

    public function actionIndex()
    {
        $forums = new Query;
        $forums->select('forum_url,forum_name,forum_desc,forum_icon')
            ->from('{{%forum}}')
            ->where('status=1')
            ->orderBy('id DESC');
        $forums = Yii::$app->tools->Pagination($forums);

        if (!Yii::$app->user->isGuest) {
            $myForums = Yii::$app->db->createCommand('SELECT forum_url, forum_name, forum_icon, status FROM {{%forum}} WHERE user_id=' . Yii::$app->user->id)->queryAll();
        } else {
            $myForums = null;
        }

        return $this->render('index', [
            'forums' => $forums,
            'myForums' => $myForums
        ]);
    }

    public function actionPosts()
    {
        $query = new Query;
        $query->select('e.id, title, content, e.created_at, u.username, u.avatar')
            ->from('{{%home_post}} as e')
            ->join('LEFT JOIN','{{%user}} as u', 'u.id=e.user_id')
            ->where('e.explore_status=1')
            ->orderBy('e.id DESC');
            
        //按标签查询出文章
        if (Yii::$app->request->isGet) {
            $tag = Yii::$app->request->get('tag');
            $query->where('tags LIKE :tag', [':tag' => '%' . $tag . '%'])->andWhere('explore_status=1');
        }
        $posts = Yii::$app->tools->Pagination($query, 10);

        //标签列表
        $query = new TaggingQuery;
        $tags = $query->select('tags')
            ->from('{{%home_post}}')
            ->where('explore_status=1')
            ->limit(10)
            ->displaySort(['freq' => SORT_DESC])
            ->getTags();
        return $this->render('posts', [
            'posts' => $posts,
            'tags' => $tags
        ]);
    }

    public function actionPhotos()
    {
        $query = new Query;
        $query->select('a.id, a.name, p.path, u.username, u.avatar')
            ->from('{{%home_album}} as a')
            ->join('LEFT JOIN','{{%home_photo}} as p', 'p.album_id=a.id')
            ->join('LEFT JOIN','{{%user}} as u', 'a.created_by=u.id')
            ->where('a.status=:type', [':type' => Album::TYPE_PUBLIC])
            ->orderBy('a.id DESC');
        $photosResult = Yii::$app->tools->Pagination($query, 25);

        return $this->render('photos', [
            'photos' => $photosResult['result'],
            'pages' => $photosResult['pages'],
        ]);
    }

    public function actionViewAlbum($id)
    {
        if (($model = Album::findOne($id)) === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        if ($model->status != Album::TYPE_PUBLIC) {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }

        return $this->render('viewAlbum', [
            'model' => $model
        ]);
    }

    public function actionViewPost($id)
    {
        $query = new Query;
        $id = intval($id);
        $model = $query->select('e.id, title, summary, content, view_count, e.created_at, origin, e.username, u.username as author, table_id, table_name')
            ->from('{{%explore_recommend}} as e')
            ->join('LEFT JOIN','{{%user}} as u', 'u.id=e.user_id')
            ->where('e.id=:id AND category="post"', [':id' => $id])
            ->one();
        if ($model == null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        Yii::$app->db->createCommand("UPDATE {{%explore_recommend}} SET view_count=view_count+1 WHERE id=:id")->bindValue(':id', $id)->execute();

        if ($model['table_name'] == 'home_post') {
            return $this->redirect(['/user/view/view-post', 'id' => $model['table_id']]);
        } elseif ($model['table_name'] == 'forum_thread') {
            return $this->redirect(['/forum/thread/view', 'id' => $model['table_id']]);
        }

        return $this->render('viewPost', [
            'model' => $model
        ]);
    }
}
