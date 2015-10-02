<?php

namespace backend\modules\forum\controllers;

use Yii;
use backend\modules\forum\models\Broadcast;
use common\components\BaseController;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;

/**
 * BroadcastController implements the CRUD actions for Broadcast model.
 */
class BroadcastController extends BaseController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'upload' => [
                'class' => 'shiyang\umeditor\UMeditorAction',
            ]
        ];
    }
    
    /**
     * 删除广播
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $forum_url = Yii::$app->db
            ->createCommand('SELECT forum_url FROM {{%forum}} WHERE id=' . $model->forum_id)
            ->queryScalar();
        $model->delete();
        Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Deleted successfully.'));
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
