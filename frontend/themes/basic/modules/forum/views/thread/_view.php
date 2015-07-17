<?php 
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;

$user = $data->user;
?>
<article class="thread-view">
    <header class="thread-head">
        <h1><?= Html::a(Html::encode($data->title), $data->url) ?></h1>
        <div class="thread-info">
            <span class="glyphicon glyphicon-user"></span> <?= Html::a(Html::encode($user['username']), ['/user/view', 'id' => $user['id']]) ?>
            &nbsp;•&nbsp;
            <span class="glyphicon glyphicon-time"></span> <?= \app\components\Tools::formatTime($data->created_at) ?>
            <div class="pull-right">
                <?php if ($user['id'] == Yii::$app->user->id): ?>
                    <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . Yii::t('app', 'Delete'), ['/user/view', 'id' => $user['id']]) ?>
                <?php endif ?>
                <span class="glyphicon glyphicon-comment"></span> <?= $data->post_count ?>
                <?php if (Yii::$app->user->id == $user['user_id']): ?>
                    &nbsp;<a href="<?= Url::toRoute(['/forum/thread/delete', 'id' => $thread['id']]) ?>"  data-confirm="<?= Yii::t('app', 'Are you sure to delete it?') ?>" data-method="thread">
                        <span class="glyphicon glyphicon-trash"></span> <?= Yii::t('app', 'Delete') ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </header>
    <article class="thread-main">
         <?= HtmlPurifier::process($data->content) ?>
    </article>
</article>
