<?php

namespace app\modules\user\controllers;

use Yii;
use yii\db\Query;
use yii\data\SqlDataProvider;
use app\components\FrontController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\components\Tools;
use app\modules\user\models\User;
use app\modules\user\models\Message;

/**
 * MessageController implements the CRUD actions for Message model.
 */
class MessageController extends FrontController
{
    public $defaultAction = 'inbox';
    public $layout = 'message';
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
                        'actions' => ['inbox', 'outbox', 'create', 'view', 'update', 'comment'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionInbox()
    {
        $user = $this->findModel();

        $query = new Query;
        $query->select('*')
            ->from('{{%user_message}}')
            ->where('sendto=:sendto', [':sendto' => $user->id])
            ->orderBy('create_time DESC');
        $pages = Tools::Pagination($query);

        return $this->render('inbox', [
            'messages' => $pages['result'],
            'pages' => $pages['pages'],
            'count' => $this->getMessageCount()
        ]);
    }

    public function actionComment()
    {
        $user = $this->findModel();
        return $this->render('comment', [
            'user' => $user,
            'count' => $this->getMessageCount()
        ]);
    }

    public function actionOutbox()
    {
        $user = $this->findModel();
        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT * FROM {{%user_message}} WHERE sendfrom=:sendfrom',
            'params' => [':sendfrom' => $user->id],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->render('outbox', [
            'dataProvider' => $dataProvider,
            'count' => $this->getMessageCount()
        ]);
    }

    /**
     * Displays a single Message model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = Message::findOne($id);
        if (!$model->read_indicator) {
            $model->read_indicator = 1;
            $model->update();
        }
        
        return $this->render('view', [
            'model' => $model,
            'count' => $this->getMessageCount()
        ]);
    }

    /**
     * Creates a new Message model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Message();

        if ($model->load(Yii::$app->request->post())) {
            if (!empty($model->userid)) {
                $model->sendto = $model->userid;
                if ($model->save()) {
                    Yii::$app->getSession()->setFlash('success', 'Sent successfully');
                }
            } else {
                $model->addError('sendto', Yii::t('app','User not found'));
            }
        }

        return $this->render('create', [
            'model' => $model,
            'count' => $this->getMessageCount()
        ]);
    }

    /**
     * Updates an existing Message model.
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
     * Deletes an existing Message model.
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
     * Finds the User model based on its primary key value.
     * @return User the loaded model
     */
    protected function findModel()
    {
        $id = Yii::$app->user->identity->id;
        return User::findOne($id);
    }

    protected function getMessageCount()
    {
        $count['inbox'] = Yii::$app->db
            ->createCommand("SELECT count(*) FROM {{%user_message}} WHERE inbox=1 and sendto=". Yii::$app->user->id)
            ->queryScalar();
        $count['outbox'] = Yii::$app->db
            ->createCommand("SELECT count(*) FROM {{%user_message}} WHERE outbox=1 and sendfrom=". Yii::$app->user->id)
            ->queryScalar();
        $count['comment'] = Yii::$app->db
            ->createCommand("SELECT unread_comment_count FROM {{%user_data}} WHERE user_id=". Yii::$app->user->id)
            ->queryScalar();
        return $count;
    }
}
