<?php

namespace app\modules\home\controllers;

use Yii;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\modules\home\models\Post;
use app\components\Tools;
use app\components\FrontController;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends FrontController
{
    public $layout = '@app/modules/user/views/layouts/profile';
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['create', 'update', 'view', 'upload', 'index', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
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

    public function actionIndex()
    {
        $this->layout = '@app/modules/user/views/layouts/user';
        $query = new Query;
        $query = $query->select('*')
            ->from('{{%home_post}}')
            ->where('user_id=:user_id', [':user_id' => Yii::$app->user->id])
            ->orderBy('create_time DESC');

        $pages = Tools::Pagination($query);
        return $this->render('index', [
            'posts' => $pages['result'],
            'pages' => $pages['pages']
        ]);
    }
    
    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = '@app/modules/user/views/layouts/user';
        $model = new Post();

        if ($model->load(Yii::$app->request->post())) {

            $tags = trim($_POST['Post']['tags']);    	                $explodeTags = array_unique(explode(',', str_replace(array (' ' , '，' ), array('',','), $tags)));    	        	                $explodeTags = array_slice($explodeTags, 0, 10);  
            $model->tags = implode(',',$explodeTags);
            
            if ($model->save()) {
                Yii::$app->userData->updateKey('post_count', Yii::$app->user->id);
                return $this->redirect(['/user/dashboard']);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->layout = '@app/modules/user/views/layouts/user';
        $model = $this->findModel($id);
        if ($model->user_id !== Yii::$app->user->id) {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->user_id === Yii::$app->user->id) {
            $model->delete();
            Yii::$app->userData->updateKey('post_count', Yii::$app->user->id);
            Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Delete successfully.'));
        } else {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
