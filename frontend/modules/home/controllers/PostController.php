<?php
/**
 * @link http://www.iisns.com/
 * @copyright Copyright (c) 2015 iiSNS
 * @license http://www.iisns.com/license/
 */

namespace app\modules\home\controllers;

use Yii;
use yii\db\Query;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Html;
use app\modules\home\models\Post;
use app\modules\home\models\Feed;
use common\components\BaseController;
use justinvoelker\tagging\TaggingQuery;

/**
 * PostController implements the CRUD actions for Post model.
 *
 * @author Shiyang <dr@shiyang.me>
 */
class PostController extends BaseController
{
    public $layout = '@app/modules/user/views/layouts/user';
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
                        'actions' => ['create', 'update', 'view', 'umeditor_upload', 'editormd_upload', 'index', 'delete'],
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
            'umeditor_upload' => [
                'class' => 'common\widgets\umeditor\UMeditorAction',
            ],
            'editormd_upload' =>  [
                'class' => 'common\widgets\editormd\EditormdAction',
            ]
        ];
    }

    public function actionIndex()
    {
        $query = new Query;
        $query = $query->select('*')
            ->from('{{%home_post}}')
            ->where('user_id=:user_id', [':user_id' => Yii::$app->user->id])
            ->orderBy('created_at DESC');
        //按标签查询出文章
        if (Yii::$app->request->isGet) {
            $tag = Yii::$app->request->get('tag');
            $query->andWhere('tags LIKE :tag', [':tag' => '%' . $tag . '%']);
        }
        $posts = Yii::$app->tools->Pagination($query);

        //标签列表
        $query = new TaggingQuery;
        $tags = $query->select('tags')
            ->from('{{%home_post}}')
            ->where('user_id=:user_id', [':user_id' => Yii::$app->user->id])
            ->displaySort(['freq' => SORT_DESC])
            ->getTags();
        return $this->render('index', [
            'tags' => $tags,
            'posts' => $posts['result'],
            'pages' => $posts['pages']
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
     * @param string $editor
     * @return mixed
     */
    public function actionCreate($editor = 'html')
    {
        $model = new Post();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->success(Yii::t('app', 'Create successfully.'));
            return $this->redirect(['/home/post']);
        }
        return $this->render('create', [
            'model' => $model,
            'editor' => $editor
        ]);
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be request
     */
    public function actionUpdate($id, $editor = 'html')
    {
        $model = $this->findModel($id);
        if ($model->user_id !== Yii::$app->user->id) {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }

        if (!empty($model->markdown))
            $editor = 'markdown';
        else if (empty($model->markdown) && !empty($model->content))
            $editor = 'html';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'editor' => $editor
            ]);
        }
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be request
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if (Yii::$app->Request->isAjax && $model->user_id === Yii::$app->user->id) {
            $model->delete();
            Yii::$app->userData->updateKey('post_count', Yii::$app->user->id, -1);
            return true;
        } else {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }
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
