<?php

namespace app\modules\user\models;

use Yii;
use yii\db\Query;
use app\components\Tools;
use app\modules\home\models\Post;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $auth_key
 * @property integer $role
 * @property integer $status
 * @property string $email
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $avatar
 */
class User extends \common\models\User
{
    public $oldPassword;
    public $newPassword;
    public $verifyPassword;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username'], 'required'],
            [['username'], 'string', 'max' => 32, 'min' => 5],
            [['username'], 'match', 'pattern' => '/^(?!_)(?!.*?_$)(?!\d{5,32}$)[a-z\d_]{5,32}$/i'],
            [['role', 'status', 'created_at', 'updated_at'], 'integer'],
            [['password_hash', 'password_reset_token', 'auth_key'], 'string'],
            [['email'], 'email'],
            [['avatar'], 'string', 'max' => 24],
            [['email'], 'unique'],
            [['username'], 'unique'],
            // oldPassword is validated by validateOldPassword()
            [['oldPassword'], 'validateOldPassword'],
            [['verifyPassword'], 'compare', 'compareAttribute' => 'newPassword'],
            [['oldPassword', 'verifyPassword', 'newPassword'], 'required']
        ];
    }

    public function validateOldPassword()
    {
        $user = parent::findOne($this->id);

        if (!$user || !$user->validatePassword($this->oldPassword)) {
            Yii::$app->getSession()->setFlash('error', 'Incorrect password.');
            $this->addError('password', 'Incorrect password.');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'oldPassword' => Yii::t('app', 'Old Password'),
            'newPassword' => Yii::t('app', 'New Password'),
            'verifyPassword' => Yii::t('app', 'Verify Password'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'role' => Yii::t('app', 'Role'),
            'status' => Yii::t('app', 'Status'),
            'email' => Yii::t('app', 'Email'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'avatar' => Yii::t('app', 'User Icon'),
        ];
    }

    public function scenarios()
    {
        return [
            'default' => ['username', 'email'],
            'security' => ['oldPassword', 'newPassword', 'verifyPassword'],
        ];
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * app\modules\home\models\Post
     * @return array
     */
    public function getPosts()
    {
        //return $this->hasMany(Post::className(), ['user_id' => 'id'])->orderBy('id DESC');
        $query = Post::find()->where(['user_id' => $this->id])->orderBy('id desc');
        $countQuery = clone $query;
        $pages = new \yii\data\Pagination(['totalCount' => $countQuery->count()]);
        $pages->defaultPageSize = 14;
        $posts = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return ['posts' => $posts, 'pages' => $pages];
    }
    
    public function getForumPosts()
    {
        // $query = new Query;
        // $posts = $query->select('id,title,content,create_time')
        //     ->from('{{%forum_post}}');
    }
    
    public static function getInfo($id)
    {
        $query = new Query;
        $user = $query->select('username, avatar')
                ->from('{{%user}}')
                ->where('id=:id', [':id' => $id])
                ->one();
        return $user;
    }

    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['user_id' => 'id']);
    }

    /**
     * 获取论坛的评论
     */
    public function getComments()
    {
        $query = new Query;
        $query = $query->select('t.id, t.title, t.content, p.user_id, p.content as comment, p.create_time')
            ->from('{{%forum_post}} as p')
            ->join('LEFT JOIN','{{%forum_thread}} as t', 'p.thread_id=t.id')
            ->where('t.user_id=:user_id and p.user_id !=:user_id', [':user_id' => $this->id])
            ->orderBy('p.create_time DESC');

        return Tools::Pagination($query);
    }
}
