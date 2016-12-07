<?php
/**
 * @link http://www.iisns.com/
 * @copyright Copyright (c) 2015 iiSNS
 * @license http://www.iisns.com/license/
 */

namespace app\modules\user\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use app\modules\user\models\User;
use app\modules\user\models\Profile;
use common\components\BaseController;

/**
 * @author Shiyang <dr@shiyang.me>
 */
class SettingController extends BaseController
{
    public $defaultAction = 'profile';
    public $enableCsrfValidation = false;
    public $layout = 'setting';
    
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
                        'actions' => ['profile', 'account', 'security', 'avatar'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionProfile()
    {
        $model = $this->findModel();
        $profile = Profile::find()->where(['user_id' => $model->id])->one();

        //上传头像
        if (Yii::$app->request->isPost && !empty($_FILES)) {
            $model->saveAvatar();
        }

        if ($profile->load(Yii::$app->request->post()) && $profile->save()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Saved successfully'));
        }
        return $this->render('profile', [
            'profile' => $profile,
            'model' => $model,
        ]);
    }
    
    public function actionAccount()
    {
        $model = $this->findModel();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Saved successfully'));
        }

        return $this->render('account', [
            'model' => $model,
        ]);
    }
    
    public function actionSecurity()
    {
        $model = $this->findModel();
        $model->scenario = 'security';
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->setPassword($model->newPassword);
                if ($model->save()) {
                    Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Saved successfully'));
                }
            }
        }
        return $this->render('security', [
            'model' => $model,
        ]);
    }

    /**
     * 选择系统头像
     */
    public function actionAvatar($name = null)
	{
        if (Yii::$app->request->isAjax) {
            if (($name = intval($name))) {
                if ($name >= 1 && $name <= 40) {
                    //删除旧头像
                    $avatar = Yii::$app->user->identity->avatar;
                    $path = Yii::getAlias('@webroot/uploads/user/avatar/') . $avatar;
                    if (file_exists($path) && (strpos($avatar, 'default') === false))
                        @unlink($path); 
                    return Yii::$app->db->createCommand()->update('{{%user}}', [
                        'avatar' => 'default/' . $name . '.jpg',
                    ], 'id=:id', [':id' => Yii::$app->user->id])->execute();
                } else {
                    throw new NotFoundHttpException('The requested page does not exist.');
                }
            } else {
                return $this->renderAjax('avatar');
            }
        } else {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }
	}

    /**
     * Finds the User model based on its primary key value.
     * @return User the loaded model
     */
    protected function findModel()
    {
        return User::findOne(Yii::$app->user->id);
    }
}
