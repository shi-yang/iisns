<?php
/**
 * @link http://www.iisns.com/
 * @copyright Copyright (c) 2015 iiSNS
 * @license http://www.iisns.com/license/
 */

namespace app\modules\forum\controllers;

use Yii;
use app\modules\forum\models\Broadcast;
use common\components\BaseController;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;

/**
 * BroadcastController implements the CRUD actions for Broadcast model.
 *
 * @author Shiyang <dr@shiyang.me>
 */
class BroadcastController extends BaseController
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
                'class' => 'common\widgets\umeditor\UMeditorAction',
            ]
        ];
    }

    public function actionUpdate($id)
    {
        $this->layout = 'forum';
        $model = $this->findModel($id);

        if ($model->user_id === Yii::$app->user->id) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $this->success(Yii::t('app', 'Saved successfully.'));
            }
            return $this->render('update', [
                'model' => $model
            ]);
        } else {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }
    }
    
    /**
     * 删除广播
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->user_id === Yii::$app->user->id) {
            $forum_url = Yii::$app->db
                ->createCommand('SELECT forum_url FROM {{%forum}} WHERE id=' . $model->forum_id)
                ->queryScalar();
            $model->delete();
            $this->success(Yii::t('app', 'Deleted successfully.'));
            return $this->redirect(['/forum/forum/broadcast', 'id' => $forum_url]);
        } else {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }
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
