<?php

namespace backend\modules\forum\controllers;

use Yii;
use backend\modules\forum\models\Board;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use backend\modules\forum\models\Thread;

/**
 * BoardController implements the CRUD actions for Board model.
 */
class BoardController extends Controller
{
    public $layout = 'forum';

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['board'],
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
     * Displays a single Board model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        if ($model->parent_id == Board::AS_CATEGORY) {
            return $this->render('boards', [
                'model' => $model,
                'forum' => $model->forumModel,
                'parentId' => $model->id,
            ]);
        }

        $newThread = new Thread();

        if ($newThread->load(Yii::$app->request->post())) {
            $newThread->board_id = $model->id;
            if ($newThread->save()) {
                Yii::$app->db->createCommand()->update('{{%forum_board}}', [
                    'updated_at' => time(),
                    'updated_by' => Yii::$app->user->id
                ], 'id=:id', [':id' => $model->id])->execute();
                return $this->refresh();
            }
        }
        
        return $this->render('view', [
            'model' => $model,
            'newThread' => $newThread,
        ]);
    }

    /**
     * Updates an existing Board model.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->user_id !== Yii::$app->user->id) {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', 'Save successfully.');
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Board model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $forum_url = $model->forum['forum_url'];
        if ($model->user_id === Yii::$app->user->id) {
            Thread::deleteAll(['board_id' => $model->id]);
            $model->delete();
            Yii::$app->getSession()->setFlash('success', 'Delete successfully.');
        } else {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }
        return $this->redirect(['/forum/forum/update', 'id' => $forum_url, 'action' => 'board']);
    }

    /**
     * Finds the Board model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Board the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Board::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
