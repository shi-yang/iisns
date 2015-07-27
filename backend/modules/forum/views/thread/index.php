<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\HtmlPurifier;
use shiyang\infinitescroll\InfiniteScrollPager;

/* @var $this yii\web\View */

$this->title = Yii::$app->setting->get('siteTitle');
?>
<div class="thread-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a(Yii::t('app', 'Create Thread'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <ul class="timeline">
        <?php foreach($models as $thread): ?>
            <li>
                <i class="glyphicon glyphicon-list-alt bg-blue"></i>
                <div class="timeline-item">
                    <span class="time"><?= Yii::$app->formatter->asRelativeTime($thread['created_at']) ?></span>
                    <h3 class="timeline-header"><span class="new-icon"></span>
                        <a href="<?= Url::toRoute(['/thread/view', 'id' => $thread['id']]) ?>" title="?" target="_blank"><?= Html::encode($thread['title']) ?></a>
                    </h3>
                    <div class="timeline-body">
                        <p><?= HtmlPurifier::process(mb_substr(strip_tags($thread['content']), 0, 140, 'utf-8')) ?></p>
                    </div>
                    <div class="timeline-footer">
                        <a class="btn btn-primary btn-xs" href="<?= Url::toRoute(['/forum/thread/view', 'id' => $thread['id']]) ?>" target="_blank"><?= Yii::t('app', 'Read more') ?></a>
                        <a class="btn btn-danger btn-xs"  href="<?= Url::toRoute(['/forum/thread/delete', 'id' => $thread['id']]) ?>" data-confirm="<?= Yii::t('app', 'Are you sure to delete it?') ?>" data-method="post">
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
