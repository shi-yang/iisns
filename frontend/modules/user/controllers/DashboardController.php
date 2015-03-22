<?php

namespace app\modules\user\controllers;

use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\db\Query;
use app\modules\user\models\User;
use app\modules\blog\models\Post;
use app\components\Tools;
use app\components\FrontController;

class DashboardController extends FrontController
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
                        'actions' => ['index', 'myposts', 'myfavor', 'followpeople',
                             'followforum', 'forumpost', 'blogpost'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $model = $this->findModel();
        $query = new Query;
        
        $query = $query->select('*')
            ->from('{{%blog_post}} as p')
            ->join('LEFT JOIN','{{%user_follow}} as u', 'p.user_id=u.people_id')
            ->where('p.user_id=:user_id OR u.user_id=:user_id', [':user_id' => $model->id])
            ->orderBy('create_time DESC');

        $pages = Tools::Pagination($query);
        return $this->render('index', [
            'model' => $model,
            'posts' => $pages['result'],
            'pages' => $pages['pages']
        ]);
    }
    
    /**
     * 获取用户所关注的人所发的帖子、动态
     */
    public function actionFollowpeople()
    {
        $model = $this->findModel();
        $query = new Query;
        $query = $query->select('*')
            ->from('{{%blog_post}}' . ' p')
            ->join('JOIN','{{%follow_people}}'. ' u', 'u.people_id=p.user_id')
            ->where('u.user_id=:user_id', [':user_id' => $model->id])
            ->orderBy('create_time DESC');
        $pages = Tools::Pagination($query);
        return $this->render('followPeople', [
            'model' => $model,
            'posts' => $pages['result'],
            'pages' => $pages['pages']
        ]);
    }
    
    /**
     * 获取用户所关注的论坛所发的帖子、动态
     */
    public function actionFollowforum()
    {
        $model = $this->findModel();
        $query = new Query;
        $query = $query->select('*')
            ->from('{{%forum_broadcast}}' . ' p')
            ->join('JOIN','{{%follow_forum}}'. ' u', 'u.forum_id=p.forum_id')
            ->where('u.user_id=:user_id', [':user_id' => $model->id])
            ->orderBy('create_time DESC');
        $pages = Tools::Pagination($query);

        return $this->render('followForum', [
            'model' => $model,
            'posts' => $pages['result'],
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
                    ->from('{{%blog_post}}')
                    ->where(['user_id' => $model->id])
                    ->orderBy('create_time desc');
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
                    ->orderBy('create_time desc');
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
