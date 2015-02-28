<?php

namespace app\modules\user\controllers;

use Yii;
use app\modules\user\models\User;
use app\modules\user\models\UserSearch;
use app\components\FrontController;
use yii\web\NotFoundHttpException;
use app\modules\blog\models\Post;

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
        return $this->render('/user/view', [
            'model' => $this->findModel($id),
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
