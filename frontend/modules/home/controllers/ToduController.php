<?php
/**
 * @link http://www.iisns.com/
 * @copyright Copyright (c) 2015 iiSNS
 * @license http://www.iisns.com/license/
 */

namespace app\modules\home\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\components\BaseController;

/**
 * ToduController implements the CRUD actions for Comment model.
 *
 * @author Shiyang <dr@shiyang.me>
 * @since 2.0
 */
class ToduController extends BaseController
{
    public $layout = '@app/modules/user/views/layouts/user';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['music', 'video'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionMusic()
    {
        return $this->render('music');
    }

    public function actionVideo()
    {
        return $this->render('video');
    }
}
