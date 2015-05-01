<?php

namespace app\modules\user\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\db\Query;
use app\modules\user\models\User;
use app\components\FrontController;
class DashboardController extends FrontController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['follow', 'unfollow'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @param string $id User ID
     */
    public function actionFollow($id)
    {
    	
    }

    /**
     * @param string $id User ID
     */
    public function actionUnfollow($id)
    {
    	
    }
}
