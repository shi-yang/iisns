<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\HtmlPurifier;

/* @var $this yii\web\View */
/* @var $model app\modules\forum\models\Post */

$seoInfo = $model->seoInfo;
$this->title = $seoInfo['title'];
$this->registerMetaTag(['name' => 'keywords', 'content' => $seoInfo['keywords']]);
$this->registerMetaTag(['name' => 'description', 'content' => $seoInfo['description']]);
$this->params['forum'] = $model->forum;
$user = $model->user;
$posts = $model->posts;
$board = $model->board;
if (!$model->isOneBoard()):
    $this->params['breadcrumbs'][] = ['label' => $board['name'], 'url' => ['/forum/board/view', 'id' => $board['id']]];
endif;
$this->params['breadcrumbs'][] = $user['username'];
?>
<div class="row">
    <div class="col-sm-9">
        <article class="thread-view">
            <header class="thread-head">
                <h1><?= Html::a(Html::encode($model->title), $model->url) ?></h1>
                <div class="thread-info">
                    <span class="glyphicon glyphicon-user"></span> <?= Html::a(Html::encode($user['username']), ['/user/view', 'id' => $user['id']]) ?>
                    &nbsp;•&nbsp;
                    <span class="glyphicon glyphicon-time"></span> <?= \app\components\Tools::formatTime($model->created_at) ?>
                    <div class="pull-right">
                        <span class="glyphicon glyphicon-comment"></span> <?= $model->post_count ?>
                        <?php if ($user['id'] == Yii::$app->user->id || $board['user_id'] == Yii::$app->user->id): ?>
                            <a href="<?= Url::toRoute(['/forum/thread/update', 'id' => $model['id']]) ?>">
                                <span class="glyphicon glyphicon-pencil"></span> <?= Yii::t('app', 'Update') ?>
                            </a>
                            &nbsp;<a href="<?= Url::toRoute(['/forum/thread/delete', 'id' => $model['id']]) ?>"  data-confirm="<?= Yii::t('app', 'Are you sure to delete it?') ?>" data-method="post">
                                <span class="glyphicon glyphicon-trash"></span> <?= Yii::t('app', 'Delete') ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </header>
            <article class="thread-main">
                <?= HtmlPurifier::process($model->content) ?>
            </article>
        </article>

        <!-- Post Form Begin -->
        <?= $this->render('/post/_form',[
                'model'=>$newPost,
            ]);
        ?>
        <!-- Post Form End -->
        <?= $this->render('_posts', [
                'posts'=>$posts['posts'],
                'floor'=> $model->post_count, //楼层数
                'pageSize'=>$posts['pages']->pageSize, //分页
                'pages' => $posts['pages'], //分页
                'postCount' => $model->post_count //评论数
            ]);
        ?>
    </div>
    <div class="col-sm-3">
        <aside class="user-info">
            <div class="hidden-xs">
                <img class="img-circle img-user" src="<?= Yii::getAlias('@avatar') . $user['avatar'] ?>" alt="User avatar">
            </div>
            <div class="user-msg">
                <strong><?= Html::a(Html::encode($user['username']), ['/user/view', 'id' => $user['username']]) ?></strong>
            </div>
        </aside>
    </div>
</div>
