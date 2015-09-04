<?php
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
 */
class ExploreController extends BaseController
{
    public $layout = 'explore';

    public function actionIndex()
    {
        $albums = new Query;
        $albums = $albums->select('h.id, h.name')
            ->from('{{%home_album}} as h')
            ->join('LEFT JOIN','{{%explore_recommend}} as e', 'e.table_id=h.id')
            ->where(['e.category' => 'album'])
            ->all();

        $forums = new Query;
        $forums->select('f.forum_name, f.forum_url, f.forum_desc, f.forum_icon')
            ->from('{{%forum}} as f')
            ->join('LEFT JOIN','{{%explore_recommend}} as e', 'e.table_id=f.id')
            ->where(['e.category' => 'forum']);
        $forums = Yii::$app->tools->Pagination($forums);

        $posts = new Query;
        $posts->select('e.id, title, summary, content, view_count, e.created_at, e.username, u.username as author, table_id, table_name')
            ->from('{{%explore_recommend}} as e')
            ->join('LEFT JOIN','{{%user}} as u', 'u.id=e.user_id')
            ->where(['category' => 'post'])
            ->orderBy('e.id DESC');
        $posts = Yii::$app->tools->Pagination($posts, 10);

        return $this->render('index', [
            'forums' => $forums,
            'albums' => $albums,
            'posts' => $posts,
        ]);
    }

    public function actionForums()
    {
        $query = new Query;
        $query->select('forum_url,forum_name,forum_desc,forum_icon')
            ->from('{{%forum}}')
            ->orderBy('id DESC');
        $forumResult = Yii::$app->tools->Pagination($query);

        return $this->render('forums', [
            'forums' => $forumResult['result'],
            'pages' => $forumResult['pages'],
        ]);
    }

    public function actionPosts()
    {
        $query = new Query;
        $query->select('e.id, title, content, e.created_at, u.username, u.avatar')
            ->from('{{%home_post}} as e')
            ->join('LEFT JOIN','{{%user}} as u', 'u.id=e.user_id')
            ->orderBy('e.id DESC');
        //按标签查询出文章
        if (Yii::$app->request->isGet) {
            $tag = Yii::$app->request->get('tag');
            $query->where('tags LIKE :tag', [':tag' => '%' . $tag . '%']);
        }
        $posts = Yii::$app->tools->Pagination($query, 10);

        //标签列表
        $query = new TaggingQuery;
        $tags = $query->select('tags')
            ->from('{{%home_post}}')
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
