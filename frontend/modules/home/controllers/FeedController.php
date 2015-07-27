<?php

namespace app\modules\home\controllers;

use Yii;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Html;
use app\modules\home\models\Feed;
use common\components\BaseController;

/**
 * FeedController implements the CRUD actions for Feed model.
 */
class FeedController extends BaseController
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
                        'actions' => ['index', 'view', 'delete', 'create', 'update'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Feed models.
     * @return mixed
     */
    public function actionIndex()
    {
        $query = new Query;
        $query->select('id, content, feed_data, template, created_at')
            ->from('{{%home_feed}}')
            ->where('user_id=:user_id', [':user_id' => Yii::$app->user->id])
            ->orderBy('created_at DESC');

        $pages = Yii::$app->tools->Pagination($query);
        return $this->render('index', [
            'feeds' => $pages['result'],
            'pages' => $pages['pages']
        ]);
    }

    /**
     * Displays a single Feed model.
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
     * Creates a new Feed model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id = null)
    {
        $model = new Feed();

        $model->setScenario('repost');
        if ($id != null && $model->load(Yii::$app->request->post())) {
            $id = intval($id);
            $query = new Query;
            $feed = $query->select('f.content, f.feed_data, f.template, u.username')
                ->from('{{%home_feed}} as f')
                ->join('LEFT JOIN','{{%user}} as u', 'u.id=f.user_id')
                ->where('f.id=:id', [':id' => $id])
                ->one();
            $postData = [
                '{comment}' => $model->content,
                '{content}' => $feed['content'],
                '{username}' => Html::a($feed['username'], ['/user/view', 'id' => $feed['username']]),
                '{feed_data}' => unserialize($feed['feed_data']),
                '{template}' => $feed['template']
            ];
            Feed::addFeed('repost', $postData);
            Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Create successfully.'));
            return $this->redirect(['/user/dashboard']);
        }

        $model->setScenario('create');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->userData->updateKey('feed_count', Yii::$app->user->id);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Feed model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->user_id === Yii::$app->user->id) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        } else {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }
    }

    /**
     * Deletes an existing Feed model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if (Yii::$app->Request->isAjax && $model->user_id === Yii::$app->user->id) {
            $model->delete();
            Yii::$app->userData->updateKey('feed_count', Yii::$app->user->id, -1);
            return true;
        } else {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }
    }

    /**
     * Finds the Feed model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Feed the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Feed::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
