<?php

namespace app\modules\blog\controllers;

use Yii;
use app\components\FrontController;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\modules\blog\models\Photo;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class PhotoController extends FrontController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['photo'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
    	$this->layout = '@app/modules/user/views/layouts/user';
        return $this->render('index');
    }

    public function actionView($id)
    {
        $this->layout = '@app/modules/user/views/layouts/user';
        $model = $this->findModel($id);
        if ($model->created_by !== Yii::$app->user->id) {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }

        return $this->render('view', [
            'model' => $model
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->created_by !== Yii::$app->user->id) {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }
        $albumId = $model->album_id;
        $model->delete();
        Yii::setAlias('@photo_path', '@webroot/uploads/blog/photo/');
        @unlink(Yii::getAlias('@photo_path').$model->path); 
        return $this->redirect(['/blog/album/view', 'id' => $albumId]);
    }

    /**
     * Finds the Photo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Photo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Photo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
