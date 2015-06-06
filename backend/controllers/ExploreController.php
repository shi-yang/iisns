<?php

namespace backend\controllers;

use Yii;
use backend\models\ExploreRecommend;
use yii\data\SqlDataProvider;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ExploreController implements the CRUD actions for ExploreRecommend model.
 */
class ExploreController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all ExploreRecommend models.
     * @return mixed
     */
    public function actionIndex()
    {
        $posts = ExploreRecommend::findAll(['category' => 'post']);
        $forums = new Query;
        $forums = $forums->select('f.forum_name, f.forum_url, f.forum_desc, f.forum_icon, e.id')
            ->from('{{%forum}} as f')
            ->join('LEFT JOIN','{{%explore_recommend}} as e', 'e.table_id=f.id')
            ->where(['e.category' => 'forum'])
            ->orderBy('e.id DESC')
            ->all();
        return $this->render('index', [
            'posts' => $posts,
            'forums' => $forums
        ]);
    }

    /**
     * Displays a single ExploreRecommend model.
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
     * Creates a new ExploreRecommend model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($category)
    {
        $model = new ExploreRecommend();
        $table_id = '';
        $table_name = '';
        if ($model->load(Yii::$app->request->post())) {
            switch ($category) {
                case 'post':
                    $category = 'post';
                    if (empty($model->summary)) {
                        $model->summary = mb_substr(strip_tags($model->content), 0, 140, 'utf-8');
                    }
                    if (!empty($model->table_id) && !empty($model->table_name)) {
                        $post = Yii::$app->db->createCommand("SELECT * FROM {{%{$model->table_name}}} WHERE id=:id")->bindValue(':id', $model->table_id)->queryOne();
                        if ($post == null) {
                            echo '没有这个帖子';
                            return false;
                        } else {
                            $model->title = $post['title'];
                            $model->summary = mb_substr(strip_tags($post['content']), 0, 140, 'utf-8');
                            $model->content = $post['content'];
                            $model->user_id = $post['user_id'];
                            $table_id = $model->table_id;
                            $table_name = $model->table_name;
                        }
                    }
                    break;
                case 'album':
                    $category = 'album';
                    break;
                case 'forum':
                    $category = 'forum';
                    $table_id = Yii::$app->db->createCommand('SELECT id FROM {{%forum}} WHERE forum_name=:name')->bindValue(':name', $model->table_id)->queryScalar();
                    if ($table_id == null) {
                        echo '没有这个论坛';
                        return false;
                    }
                    $table_name = 'forum';
                    break;
                default:
                    throw new NotFoundHttpException('The requested page does not exist.');
                    break;
            }
            $model->category = $category;
            $model->created_at = time();
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('add-' . $category, [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ExploreRecommend model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ExploreRecommend model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ExploreRecommend model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ExploreRecommend the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ExploreRecommend::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
