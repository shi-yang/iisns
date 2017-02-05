<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use common\components\BaseController;
use backend\models\LoginForm;

/**
 * Site controller
 */
class SiteController extends BaseController
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
                        'actions' => ['login', 'error', 'captcha'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'phpinfo', 'cache'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $statistics['userCount'] = Yii::$app->db->createCommand("SELECT count(*) as num FROM {{%user}}")->queryScalar();
        $statistics['postCount'] = Yii::$app->db->createCommand("SELECT count(*) as num FROM {{%home_post}}")->queryScalar();
        $statistics['photoCount'] = Yii::$app->db->createCommand("SELECT count(*) as num FROM {{%home_photo}}")->queryScalar();
        $statistics['forumCount'] = Yii::$app->db->createCommand("SELECT count(*) as num FROM {{%forum}}")->queryScalar();
        return $this->render('index',[
            'statistics' => $statistics,
        ]);
    }

    public function actionPhpinfo()
    {
        ob_start();
        phpinfo();
        $pinfo = ob_get_contents();
        ob_end_clean();
        $phpinfo = preg_replace('%^.*<body>(.*)</body>.*$%ms', '$1', $pinfo);
        $phpinfo = str_replace('<table ', '<div class="table-responsive"><table class="table table-condensed table-bordered table-striped table-hover config-php-info-table"', $phpinfo);
        $phpinfo = str_replace('</table>', '</table></div>', $phpinfo);
        return $this->render('phpinfo', [
            'phpinfo' => $phpinfo
        ]);
    }

    public function actionLogin()
    {
        $this->layout = 'site';
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionCache($action = null)
    {
        switch ($action) {
            case 'clearall':
                Yii::$app->cache->flush();
                break;
            
            default:
                
                break;
        }
        return $this->render('cache');
    }
}
