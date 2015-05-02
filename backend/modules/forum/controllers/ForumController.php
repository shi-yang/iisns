<?php

namespace backend\modules\forum\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\imagine\Image;
use yii\db\Query;
use backend\modules\forum\models\Forum;
use backend\modules\forum\models\ForumSearch;
use backend\modules\forum\models\Board;
use backend\modules\forum\models\Thread;
use backend\modules\forum\models\Broadcast;

/**
 * ForumController implements the CRUD actions for Forum model.
 */
class ForumController extends Controller
{
    const BOARD = 1;

    //public $layout = 'forum';
    public $enableCsrfValidation = false;

    public function actions()
    {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
            ]
        ];
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['create', 'update', 'index', 'view', 'broadcast'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index', 'view', 'broadcast'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Forum models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ForumSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Forum model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        if ($model->boardCount == 1 && $model->boards[0]->parent_id == self::BOARD ) {
            $newThread = $this->newThread($model->boards[0]->id);
        } else {
            $newThread = null;
        }
        
        return $this->render('view', [
            'model' => $model,
            'newThread' => $newThread,
        ]);
    }
    
    public function actionBroadcast($id)
    {
        $model = $this->findModel($id);
        $newBroadcast = $this->newBroadcast($model->id);
        return $this->render('broadcast', [
            'model' => $model,
            'newBroadcast' => $newBroadcast,
        ]);
    }

    /**
     * Creates a new Forum model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Forum();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->forum_url]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Forum model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $action='dashboard')
    {
        $model = $this->findModel($id);

        $newBoard = new Board();
        if ($newBoard->load(Yii::$app->request->post())) {
            $newBoard->forum_id = $model->id;
            if ($newBoard->save()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Create successfully.'));
            } else {
                Yii::$app->getSession()->setFlash('error', 'Server error.');
            }
        }
        
        Yii::setAlias('@upload', '@webroot/uploads/forum/icon/');
        if (Yii::$app->request->isPost && !empty($_FILES)) {
            $extension =  strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
            $fileName = $model->id . '_' . time() . rand(1 , 10000) . '.' . $extension;

            Image::thumbnail($_FILES['file']['tmp_name'], 160, 160)->save(Yii::getAlias('@upload') . $fileName, ['quality' => 80]);
            
            //delete old icon
            $file_exists = file_exists(Yii::getAlias('@upload').$model->forum_icon);
            if ($file_exists && (strpos($model->forum_icon, 'default') === false))
                @unlink(Yii::getAlias('@upload').$model->forum_icon); 

            $model->forum_icon = $fileName;
            $model->update();
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate() && $model->save()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Save successfully.'));
            }
        }
        
        return $this->render('update', [
            'model' => $model,
            'newBoard' => $newBoard,
            'action' => $action
        ]);
    }

    /**
     * Finds the Forum model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Forum the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Forum::findOne($id) )!== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function newBroadcast($id)
    {
        $newBroadcast = new Broadcast();
        if ($newBroadcast->load(Yii::$app->request->post())) {
            $newBroadcast->forum_id = $id;
            $newBroadcast->save();
            $this->refresh();
        }
        return $newBroadcast;
    }

    protected function newThread($id)
    {
        $newThread = new Thread();
        if ($newThread->load(Yii::$app->request->post())) {
            $newThread->board_id = $id;
            $newThread->save();
            Yii::$app->db->createCommand()->update('{{%forum_board}}', [
                'updated_at' => time(),
                'updated_by' => Yii::$app->user->id
            ], 'id=:id', [':id' => $id])->execute();
            $this->refresh();
        }
        return $newThread;
    }
}
