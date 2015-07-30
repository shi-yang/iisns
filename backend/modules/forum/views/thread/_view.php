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
            <span class="glyphicon glyphicon-time"></span> <?= Yii::$app->formatter->asRelativeTime($data->created_at) ?>
            <div class="pull-right">
                <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . Yii::t('app', 'Delete'), ['/user/view', 'id' => $user['id']]) ?>
                <span class="glyphicon glyphicon-comment"></span> <?= $data->post_count ?>
                &nbsp;<a href="<?= Url::toRoute(['/forum/thread/delete', 'id' => $thread['id']]) ?>"  data-confirm="<?= Yii::t('app', 'Are you sure to delete it?') ?>" data-method="post">
                    <span class="glyphicon glyphicon-trash"></span> <?= Yii::t('app', 'Delete') ?>
                </a>
            </div>
        </div>
    </header>
    <article class="thread-main">
         <?= HtmlPurifier::process($data->content) ?>
    </article>
</article>
