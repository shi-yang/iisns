<?php

namespace app\modules\user\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\db\Query;
use app\modules\user\models\User;
use common\components\BaseController;

class UserController extends BaseController
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
                        'actions' => ['follow'],
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
        $id = intval($id);
    	if (Yii::$app->Request->isAjax && Yii::$app->user->id !== $id) {
            $done = Yii::$app->db
                ->createCommand("SELECT 1 FROM {{%user_follow}} WHERE user_id=:user_id AND people_id=:id LIMIT 1")
                ->bindValues([':user_id' => Yii::$app->user->id, ':id' => $id])->queryScalar();
            if ($done) {
                //已经关注，则删除记录，取消关注
                Yii::$app->db
                    ->createCommand("DELETE FROM {{%user_follow}} WHERE user_id=:user_id AND people_id=:id")
                    ->bindValues([':user_id' => Yii::$app->user->id, ':id' => $id])
                    ->execute();

                Yii::$app->userData->updateKey('following_count', Yii::$app->user->id, -1);
                Yii::$app->userData->updateKey('follower_count', $id, -1);
            } else {
                //还没有关注，则添加记录，添加关注
                Yii::$app->db->createCommand()->insert('{{%user_follow}}', [
                    'user_id' => Yii::$app->user->id,
                    'people_id' => $id
                ])->execute();

                Yii::$app->userData->updateKey('following_count', Yii::$app->user->id);
                Yii::$app->userData->updateKey('follower_count', $id);
            }
        } else {
            return false;
        }
    }
}
