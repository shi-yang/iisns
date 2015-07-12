<?php

namespace app\modules\user\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\imagine\Image;
use app\modules\user\models\User;
use app\modules\user\models\Profile;
use common\components\BaseController;

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
                        'actions' => ['profile', 'account', 'security'],
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

        Yii::setAlias('@upload', '@webroot/uploads/user/avatar/');
        if (Yii::$app->request->isPost && !empty($_FILES)) {
            $extension =  strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
            $fileName = $model->id . '_' . time() . rand(1 , 10000) . '.' . $extension;

            Image::thumbnail($_FILES['file']['tmp_name'], 160, 160)->save(Yii::getAlias('@upload') . $fileName, ['quality' => 80]);
            
            //delete old icon
            $file_exists = file_exists(Yii::getAlias('@upload').$model->avatar);
            if ($file_exists && (strpos($model->avatar, 'default') === false))
                @unlink(Yii::getAlias('@upload').$model->avatar); 

            $model->avatar = $fileName;
            $model->update();
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

    public function actionSettingFace()
	{

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
