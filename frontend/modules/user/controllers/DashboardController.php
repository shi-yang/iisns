<?php

namespace app\modules\user\controllers;

use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\db\Query;
use app\modules\user\models\User;
use app\modules\home\models\Post;
use app\modules\home\models\Feed;
use app\components\Tools;
use common\components\BaseController;

class DashboardController extends BaseController
{
    public $layout='dashboard';
    
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
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['?']
                    ],
                    [
                        'actions' => ['index', 'myposts', 'myfavor', 'followpeople',
                             'followforum', 'forumpost', 'homepost'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            $this->redirect(['/explore/index']);
        }
        $model = $this->findModel();
        $newFeed = new Feed;
        if ($newFeed->load(Yii::$app->request->post()) && $newFeed->save()) {
            Yii::$app->userData->updateKey('feed_count', Yii::$app->user->id);
            return $this->refresh();
        }

        $query = new Query;
        $query = $query->select('p.id, p.user_id, p.content, p.feed_data, p.template, p.created_at, u.username, u.avatar')
            ->from('{{%home_feed}} as p')
            ->join('LEFT JOIN','{{%user_follow}} as f', 'p.user_id=f.people_id')
            ->join('LEFT JOIN','{{%user}} as u', 'u.id=p.user_id')
            ->where('p.user_id=:user_id OR f.user_id=:user_id', [':user_id' => $model->id])
            ->orderBy('p.created_at DESC');

        $pages = Tools::Pagination($query);
        return $this->render('index', [
            'model' => $model,
            'newFeed' => $newFeed,
            'feeds' => $pages['result'],
            'pages' => $pages['pages']
        ]);
    }
    
    /**
     * My posts
     */
    public function actionBlogpost()
    {
        $model = $this->findModel();
        $query = new Query;
        $query = $query->select('*')
                    ->from('{{%home_post}}')
                    ->where(['user_id' => $model->id])
                    ->orderBy('created_at desc');
        $pages = Tools::Pagination($query);
        return $this->render('myposts', [
            'model' => $model,
            'posts' => $pages['result'],
            'pages' => $pages['pages'],
        ]);
    }

    public function actionForumpost()
    {
        $model = $this->findModel();
        $query = new Query;
        $query = $query->select('*')
                    ->from('{{%forum_post}}')
                    ->where(['user_id' => $model->id])
                    ->orderBy('created_at desc');
        $pages = Tools::Pagination($query);
        return $this->render('myposts', [
            'model' => $model,
            'posts' => $pages['result'],
            'pages' => $pages['pages'],
        ]);
    }

    public function actionMyfavor()
    {
        $model = $this->findModel();

        return $this->render('myfavor');
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
}
