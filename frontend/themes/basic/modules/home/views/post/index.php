<?php

use yii\helpers\Html;
use yii\helpers\Url;
use justinvoelker\tagging\TaggingWidget;
use shiyang\infinitescroll\InfiniteScrollPager;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'My Posts');
$this->params['breadcrumbs'][] = $this->title;

$user = Yii::$app->user->identity;
?>

<div class="post-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a(Yii::t('app', 'Create Post'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-8 col-md-8">
        <div class="post-list" id="content">
            <?php if (!empty($posts)): ?>
                <?php foreach($posts as $post): ?>
                    <article class="post-item" id="<?= $post['id'] ?>">
                        <header class="widget-content padded">
                            <h3>
                                <?php if ($post['status'] == 'private'): ?>
                                    <i class="glyphicon glyphicon-lock"></i>
                                <?php endif ?>
                                <?= Html::a(Html::encode($post['title']), ['/home/post/view', 'id' => $post['id']]) ?>
                            </h3>
                        </header>
                        <div class="post-footer">
                            &nbsp;
                            <a href="<?= Url::toRoute(['/home/post/delete', 'id' => $post['id']]) ?>" data-clicklog="delete" onclick="return false;" title="<?= Yii::t('app', 'Are you sure to delete it?') ?>">
                                <span class="glyphicon glyphicon-trash"></span> <?= Yii::t('app', 'Delete') ?>
                            </a>
                            &nbsp;
                            <span class="item-line"></span>
                            <a href="<?= Url::toRoute(['/home/post/update', 'id' => $post['id']]) ?>">
                                <span class="glyphicon glyphicon-edit"></span> <?= Yii::t('app', 'Edit') ?>
                            </a>
                            &nbsp;
                            <span class="item-line"></span>
                            <span class="glyphicon glyphicon-time"></span> <?= Yii::$app->formatter->asRelativeTime($post['created_at']) ?>
                        </div>
                    </article>
                <?php endforeach; ?>
                <?= InfiniteScrollPager::widget([
                    'pagination' => $pages,
                    'widgetId' => '#content',
                ]);?>
            <?php else: ?>
                <div class="no-data-found">
                    <i class="glyphicon glyphicon-folder-open"></i>
                    <?= Yii::t('app', 'No data to display.') ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading"><?= Yii::t('app', 'Tags') ?></div>
            <div class="panel-body">
                <?= TaggingWidget::widget([
                    'items' => $tags,
                    'url' => ['/home/post/index'],
                    'format' => 'ul',
                    'urlParam' => 'tag',
                    'listOptions' => ['class' => 'tag-group'],
                    'liOptions' => ['class' => 'tag-group-item']
                ]) ?>
            </div>
        </div>
    </div>
</div>
