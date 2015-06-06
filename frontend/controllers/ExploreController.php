<?php
namespace frontend\controllers;

use Yii;
use yii\db\Query;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\data\SqlDataProvider;
use app\components\FrontController;
use app\components\Tools;
use app\modules\home\models\Album;

Yii::setAlias('forum_icon', '@web/uploads/forum/icon/');
Yii::setAlias('avatar', '@web/uploads/user/avatar/');
Yii::setAlias('photo', '@web/uploads/home/photo/');

/**
 * Explore controller
 */
class ExploreController extends FrontController
{
    public function behaviors()
    {
        return [
            [
                'class' => 'yii\filters\PageCache',
                'only' => ['forums', 'photos'],
                'duration' => 60 * 60,
                'variations' => [
                    Yii::$app->language,
                    Yii::$app->user->isGuest,
                ],
            ],
        ];
    }
    public $layout = 'explore';

    public function actionIndex()
    {
        $albums = Yii::$app->db
            ->createCommand('SELECT `a`.`id`, `a`.`name` FROM {{%home_album}} `a` WHERE a.status=0 ORDER BY `a`.`id` DESC LIMIT 4')
            ->queryAll();

        $forums = new Query;
        $forums->select('f.forum_name, f.forum_url, f.forum_desc, f.forum_icon')
            ->from('{{%forum}} as f')
            ->join('LEFT JOIN','{{%explore_recommend}} as e', 'e.table_id=f.id')
            ->where(['e.category' => 'forum']);
        $forums = Tools::Pagination($forums);

        $posts = new Query;
        $posts->select('e.id, title, summary, content, view_count, e.created_at, e.username, u.username as author, table_id, table_name')
            ->from('{{%explore_recommend}} as e')
            ->join('LEFT JOIN','{{%user}} as u', 'u.id=e.user_id')
            ->where(['category' => 'post'])
            ->orderBy('e.id DESC');
        $posts = Tools::Pagination($posts);

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
        $forumResult = Tools::Pagination($query);

        return $this->render('forums', [
            'forums' => $forumResult['result'],
            'pages' => $forumResult['pages'],
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
        $photosResult = Tools::Pagination($query, 25);

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
        $model = $query->select('e.id, title, summary, content, view_count, e.created_at, e.username, u.username as author, table_id, table_name')
            ->from('{{%explore_recommend}} as e')
            ->join('LEFT JOIN','{{%user}} as u', 'u.id=e.user_id')
            ->where('e.id=:id AND category="post"', [':id' => $id])
            ->one();
        if ($model == null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        Yii::$app->db->createCommand("UPDATE {{%explore_recommend}} SET view_count=view_count+1 WHERE id=:id")->bindValue(':id', $id)->execute();

        if (!empty($model['author'])) {
            return $this->redirect(['/home/post/view', 'id' => $model['table_id']]);
        }

        return $this->render('viewPost', [
            'model' => $model
        ]);
    }
}
