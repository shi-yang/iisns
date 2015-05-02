<?php

namespace backend\modules\forum\controllers;

use Yii;
use backend\modules\forum\models\Broadcast;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;

/**
 * BroadcastController implements the CRUD actions for Broadcast model.
 */
class BroadcastController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['broadcast'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
            ]
        ];
    }
    
    /**
     * 
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $forum_url = Yii::$app->db
            ->createCommand('SELECT forum_url FROM {{%forum}} WHERE id=' . $model->forum_id)
            ->queryScalar();
        if ($model->user_id === Yii::$app->user->id) {
            $model->delete();
            Yii::$app->getSession()->setFlash('success', 'Delete successfully.');
        } else {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }
        return $this->redirect(['/forum/forum/broadcast', 'id' => $forum_url]);
    }

    /**
     * Finds the Broadcast model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Broadcast the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Broadcast::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
