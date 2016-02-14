<?php
/**
 * @link http://www.iisns.com/
 * @copyright Copyright (c) 2015 iiSNS
 * @license http://www.iisns.com/license/
 */

namespace app\modules\user\controllers;

use Yii;
use yii\db\Query;
use yii\data\SqlDataProvider;
use yii\helpers\Url;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use common\components\BaseController;
use app\modules\user\models\User;
use app\modules\home\models\Post;
use app\modules\home\models\Album;

/**
 * @author Shiyang <dr@shiyang.me>
 * @since 2.0
 */
class ViewController extends BaseController
{
    public $layout = 'profile';
    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionIndex($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isAjax && Yii::$app->request->get('card')) {
            $user['avatar'] = Yii::getAlias('@avatar') . $model->avatar;
            $user['username'] = $model->username;
            $user['userUrl'] = Url::toRoute(['/user/view', 'id' => $model->username]);
            $user['userData'] = Yii::$app->userData->getKey(true, null, $model->id);
            $user['followUrl'] = Url::toRoute(['/user/user/follow', 'id' => $model->id]);
            //关注的文字
            if (User::getIsFollow($model->id)) {
                $user['followBtn'] = '<span class="glyphicon glyphicon glyphicon-eye-close"></span> ' . Yii::t('app', 'Unfollow');
            } else {
                $user['followBtn'] = '<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('app', 'Follow');
            }
            return $this->renderAjax('/user/card', [
                'user' => $user
            ]);
        }

        $query = (new Query)->select('id, content, template, feed_data, created_at')
            ->from('{{%home_feed}}')
            ->where('user_id=:user_id', [':user_id' => $model->id])
            ->orderBy('created_at DESC');

        $result = Yii::$app->tools->Pagination($query);

        return $this->render('/user/view', [
            'model' => $model,
            'feeds' => $result['result'],
            'pages' => $result['pages']
        ]);
    }

    public function actionCard($id)
    {
        $model = $this->findModel($id);
    }

    public function actionAlbum($id)
    {
        $model = $this->findModel($id);
        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT id, cover_id, status, name FROM {{%home_album}} WHERE created_by = :user_id AND status=:status',
            'params' => [':user_id' => $model->id, ':status' => Album::TYPE_PUBLIC],
        ]);

        return $this->render('/user/album', [
            'model' => $model,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionPost($id)
    {
        $model = $this->findModel($id);

        $query = (new Query)->select('*')
            ->from('{{%home_post}}')
            ->where('user_id=:user_id', [':user_id' => $model->id])
            ->andWhere('status=:status', [':status' => Post::STATUS_PUBLIC])
            ->orderBy('created_at DESC');

        $posts = Yii::$app->tools->Pagination($query);
        return $this->render('/user/post', [
            'model' => $model,
            'posts' => $posts['result'],
            'pages' => $posts['pages']
        ]);
        
    }

    public function actionProfile($id)
    {
        $model = $this->findModel($id);

        return $this->render('/user/profile', [
            'model' => $model,
        ]);
    }

    public function actionViewAlbum($id)
    {
        if (($model = Album::findOne($id)) === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        if ($model->status !== Album::TYPE_PUBLIC || ($model->status !== Album::TYPE_PUBLIC && $model->created_by !== Yii::$app->user->id)) {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }

        $user = $this->findModel($model->created_by);
        return $this->render('/user/viewAlbum', [
            'model' => $model,
            'user' => $user
        ]);
    }

    public function actionViewPost($id)
    {
        if (($model = Post::findOne($id)) === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        if ($model->status !== Post::STATUS_PUBLIC || ($model->status !== Post::STATUS_PUBLIC && $model->user_id !== Yii::$app->user->id)) {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }

        return $this->render('/user/viewPost', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (is_numeric($id)) {
            $model = User::findOne($id);
        } else {
            $model = User::find()->where(['username' => $id])->one();
        }
        
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
