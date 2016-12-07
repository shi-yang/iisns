<?php
/**
 * @link http://www.iisns.com/
 * @copyright Copyright (c) 2015 iiSNS
 * @license http://www.iisns.com/license/
 */

namespace app\widgets\comment;

use Yii;
use yii\base\Widget;

/**
 * @author Shiyang <dr@shiyang.me>
 */
class Comment extends Widget
{
    /**
     * @var \yii\db\ActiveRecord|null Widget model
     */
    public $model;
    /**
     * @var string hash(crc32) from class name of the widget model
     */
    protected $entity;
    /**
     * @var integer primary key value of the widget model
     */
    protected $entityId;

    /**
     * Initializes the widget params.
     */
    public function init()
    {
        if (empty($this->model)) {
            throw new InvalidConfigException(Yii::t('app', 'The "model" property must be set.'));
        }

        $this->entity = hash('crc32', get_class($this->model));
        $this->entityId = $this->model->id;
    }

    public function run()
    {
        $commentList = \app\widgets\comment\models\Comment::getCommentList($this->entity, $this->entityId);
        $newComment = $this->newComment();
        return $this->render('comment', [
            'commentList' => $commentList['result'],
            'pages' => $commentList['pages'],
            'newComment' => $newComment,
        ]);
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
            $newComment->entity = $this->entity;
            $newComment->entity_id = $this->entityId;
            if ($newComment->save()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Create successfully.'));
                Yii::$app->getResponse()->refresh()->send();
                exit();
            } else {
                print_r($newComment->getErrors());
            }
        }
        return $newComment;
    }
}
