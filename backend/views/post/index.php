<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\HtmlPurifier;
use shiyang\infinitescroll\InfiniteScrollPager;

/* @var $this yii\web\View */
/* @var $model backend\models\Post */

$this->title = Yii::t('app', 'Posts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="timeline">
        <li class="time-label">
            <?= Html::a(Yii::t('app', 'Create a post'), ['/post/create', 'category' => 'post'], ['class' => 'btn btn-success']) ?>
        </li>
        <?php foreach($models as $post): ?>
            <li>
                <i class="glyphicon glyphicon-list-alt bg-blue"></i>
                <div class="timeline-item">
                    <span class="time"><?= Yii::$app->formatter->asRelativeTime($post['created_at']) ?></span>
                    <h3 class="timeline-header"><span class="new-icon"></span>
                        <a href="<?= Url::toRoute(['/post/view', 'id' => $post['id']]) ?>" title="?" target="_blank"><?= Html::encode($post['title']) ?></a>
                    </h3>
                    <div class="timeline-body">
                        <p><?= HtmlPurifier::process(mb_substr(strip_tags($post['content']), 0, 140, 'utf-8')) ?></p>
                    </div>
                    <div class="timeline-footer">
                        <a class="btn btn-primary btn-xs" href="<?= Url::toRoute(['/post/view', 'id' => $post['id']]) ?>" target="_blank"><?= Yii::t('app', 'Read more') ?></a>
                        <a class="btn btn-danger btn-xs"  href="<?= Url::toRoute(['/post/delete', 'id' => $post['id']]) ?>" data-confirm="<?= Yii::t('app', 'Are you sure to delete it?') ?>" data-method="post">
                            <span class="glyphicon glyphicon-trash"></span> <?= Yii::t('app', 'Delete') ?>
                        </a>
                    </div>
                </div>
            </li>
        <?php endforeach ?>
        <?= InfiniteScrollPager::widget([
            'pagination' => $pages,
            'widgetId' => '.timeline',
        ]);?>
    </ul>
</div>
