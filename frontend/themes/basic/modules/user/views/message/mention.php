<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use shiyang\infinitescroll\InfiniteScrollPager;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Mention me');
$this->params['breadcrumbs'][] = $this->title;
$this->params['count'] = $count;
?>

<ul class="media-list" id="notice-content" style="padding:20px">
    <?php foreach ($notices['result'] as $notice): ?>
    <li class="media">
        <div class="media-left">
            <a href="<?= Url::toRoute(['/user/view', 'id' => $notice['username']]) ?>">
                <img class="media-object img-circle" alt="User avatar" src="<?= Yii::getAlias('@avatar') . $notice['avatar'] ?>" style="width: 64px; height: 64px;">
            </a>
        </div>
        <div class="media-body">
            <h4 class="media-heading">
                <?= Html::a($notice['username'], ['/user/view', 'id' => $notice['username']]) ?>
                <?= Yii::t('notice', $notice['type_title'], unserialize($notice['title'])); ?>
            </h4>
            <p><?= $notice['content'] ?></p>
            <p>
                <?= Yii::$app->formatter->asRelativeTime($notice['created_at']) ?>
                <a class="pull-right" href="<?= Url::toRoute(unserialize($notice['source_url'])) ?>"><?= Yii::t('app', 'View Details') ?></a>
            </p>
        </div>
    </li>
    <?php endforeach ?>
    <?= InfiniteScrollPager::widget([
        'pagination' => $notices['pages'],
        'widgetId' => '#notice-content',
    ]); ?>
</ul>
