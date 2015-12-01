<?php
/**
 * @link http://www.iisns.com/
 * @copyright Copyright (c) 2015 iiSNS
 * @license http://www.iisns.com/license/
 */

namespace app\modules\user\controllers;

use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\db\Query;
use app\modules\user\models\User;
use app\modules\home\models\Post;
use app\modules\home\models\Feed;
use common\components\BaseController;

/** 
 *@author Shiyang <dr@shiyang.me>
 * @since 2.0
 */
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
                        'actions' => ['index', 'myposts', 'myfavor', 'following', 'follower', 'forumpost', 'homepost'],
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
        $newFeed->setScenario('create');
        if ($newFeed->load(Yii::$app->request->post()) && $newFeed->save()) {
            Yii::$app->userData->updateKey('feed_count', Yii::$app->user->id);
            return $this->refresh();
        }

        $query = new Query;
        $query = $query->select('p.id, p.user_id, p.content, p.feed_data, p.template, p.created_at, u.username, u.avatar')
            ->from('{{%home_feed}} as p')
            ->join('LEFT JOIN','{{%user_follow}} as f', 'p.user_id=f.people_id AND f.user_id=:user_id')
            ->join('LEFT JOIN','{{%user}} as u', 'u.id=p.user_id')
            ->where('p.user_id=:user_id OR f.user_id=:user_id', [':user_id' => $model->id])
            ->orderBy('p.created_at DESC');

        $pages = Yii::$app->tools->Pagination($query);
        return $this->render('index', [
            'model' => $model,
            'newFeed' => $newFeed,
            'feeds' => $pages['result'],
            'pages' => $pages['pages']
        ]);
    }

    public function actionFollowing()
    {
        return $this->render('follow', [
            'title' => Yii::t('app', 'You\'re Following'),
            'type' => 'following',
            'model' => $this->findModel()
        ]);
    }

    public function actionFollower()
    {
        return $this->render('follow', [
            'title' => Yii::t('app', 'Your Followers'),
            'type' => 'follower',
            'model' => $this->findModel()
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
