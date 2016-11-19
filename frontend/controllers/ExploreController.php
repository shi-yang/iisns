<?php
/**
 * @link http://www.iisns.com/
 * @copyright Copyright (c) 2015 iiSNS
 * @license http://www.iisns.com/license/
 */
 
namespace frontend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use common\components\BaseController;
use app\modules\home\models\Album;
use frontend\models\Explore;

Yii::setAlias('forum_icon', '@web/uploads/forum/icon/');
Yii::setAlias('avatar', '@web/uploads/user/avatar/');
Yii::setAlias('photo', '@web/uploads/home/photo/');

/**
 * Explore controller
 *
 * @author Shiyang <dr@shiyang.me>
 */
class ExploreController extends BaseController
{
    public $layout = 'explore';

    public function actionIndex()
    {
        return $this->render('index', [
            'forums' => Explore::getForumList(),
            'myForums' => Explore::getCurrentUserForum()
        ]);
    }

    public function actionPosts()
    {
        $query = Explore::getPostQuery();
        //按标签查询出文章
        if (Yii::$app->request->isGet) {
            $tag = Yii::$app->request->get('tag');
            $query->andWhere('tags LIKE :tag', [':tag' => '%' . $tag . '%'])->where('e.explore_status=1');
        }
        $posts = Yii::$app->tools->Pagination($query, 10);
        $tags = Explore::getPostTags();
        return $this->render('posts', [
            'posts' => $posts,
            'tags' => $tags
        ]);
    }

    public function actionPhotos()
    {
        return $this->render('photos', [
            'photos' => Explore::getAllPhotos()
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
}
