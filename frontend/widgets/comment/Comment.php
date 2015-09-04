<?php

namespace app\widgets\comment;

use Yii;
use yii\base\Widget;
use yii\db\Query;

class Comment extends Widget
{
    /**
     * @var integer 评论所属表的 ID
     */
    public $tableId;
    /**
     * @var string 评论所属表名，为 [[yii\db\ActiveRecord::tableName()]]
     */
    public $tableName;

    public function run()
    {
        $commentList = $this->getCommentList();
        $newComment = $this->newComment();
        return $this->render('comment', [
            'commentList' => $commentList['result'],
            'pages' => $commentList['pages'],
            'newComment' => $newComment,
        ]);
    }

    /**
     * 获取评论列表
     * @return array
     */
    public function getCommentList()
    {
        $query =  (new Query)->select('c.id, c.content, c.parent_id, u.username, u.avatar')
            ->from('{{%comment}} as c')
            ->join('LEFT JOIN','{{%user}} as u', 'u.id=c.user_id')
            ->where('table_id=:tableId AND table_name=:tableName AND parent_id = 0', [':tableId' => $this->tableId, 'tableName' => $this->tableName]);
        return Yii::$app->tools->Pagination($query, 15);
    }

    /**
     * 创建新评论
     * @return \app\widgets\comment\models\Comment|\yii\web\Response
     */
    public function newComment()
    {
        $newComment = new \app\widgets\comment\models\Comment();
        if ($newComment->load(Yii::$app->request->post())) {
            if (Yii::$app->user->isGuest) {
                Yii::$app->getSession()->setFlash('info', Yii::t('app', 'You need to sign in or sign up before continuing.'));
                return Yii::$app->getResponse()->redirect(['/site/login']);
            }
            $newComment->table_id = $this->tableId;
            $newComment->table_name = $this->tableName;
            if ($newComment->save()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Create successfully.'));
                return Yii::$app->getResponse()->refresh();
            } else {
                print_r($newComment->getErrors());
            }
        }
        return $newComment;
    }
}
