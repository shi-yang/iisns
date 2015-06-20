<?php

namespace app\modules\user\controllers;

use Yii;
use app\modules\user\models\User;
use app\modules\user\models\UserSearch;
use app\components\FrontController;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;
use app\modules\home\models\Post;

/**
 * UserController implements the CRUD actions for User model.
 */
class ViewController extends FrontController
{
    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionIndex($id)
    {
        $this->layout = 'profile';
        $model = $this->findModel($id);

        if (Yii::$app->Request->isAjax) {
            $avatar = Yii::getAlias('@avatar') . $model->avatar;
            $username = $model->username;
            $userUrl = Url::toRoute(['/user/view', 'id' => $username]);
            $userData = Yii::$app->userData->getKey(true, null, $model->id);
            $followUrl = Url::toRoute(['/user/user/follow', 'id' => $model->id]);

            //判断是否已经关注该用户
            $done = Yii::$app->db
                ->createCommand("SELECT 1 FROM {{%user_follow}} WHERE user_id=:user_id AND people_id=:id LIMIT 1")
                ->bindValues([':user_id' => Yii::$app->user->id, ':id' => $model->id])->queryScalar();
            if ($done) {
                $followBtn = '<span class="glyphicon glyphicon glyphicon-eye-close"></span> ' . Yii::t('app', 'Unfollow');
            } else {
                $followBtn = '<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('app', 'Follow');
            }
            
            $html =<<<HTML
              <div class="media">
                <div class="media-left">
                  <a href="{$userUrl}">
                    <img class="media-object" src="{$avatar}" alt="{$username}">
                  </a>
                </div>
                <div class="media-body">
                  <h4 class="media-heading">$model->username</h4>
                </div>
                <div class="media-footer">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <span class="block font-14">{$userData['following_count']}</span><br>
                    <small class="text-muted">关注</small>
                  </div><!-- /.col -->
                  <div class="col-xs-4 text-center">
                    <span class="block font-14">{$userData['follower_count']}</span><br>
                    <small class="text-muted">粉丝</small>
                  </div><!-- /.col -->
                  <div class="col-xs-4 text-center">
                    <span class="block font-14">{$userData['feed_count']}</span><br>
                    <small class="text-muted">文章</small>
                  </div><!-- /.col -->
                </div>
                <a class="btn btn-xs btn-success btn-follow" href="{$followUrl}">
                    {$followBtn}
                </a>
              </div>
HTML;
            return $html;
        }

        return $this->render('/user/view', [
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
