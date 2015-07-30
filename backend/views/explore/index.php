<?php

use yii\helpers\Html;
use yii\helpers\Url;
use shiyang\infinitescroll\InfiniteScrollPager;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Explore');
$this->registerCss('
.album-all {
list-style-type: none;
}
.album-item {
    float:left;
    padding: 6px;
    border-width: 0;
    border-bottom-width: 1px\9;
    box-shadow: 0 1px 4px rgba(0,0,0,.15);
    width: 170px;
}
.add-album {
    font-size:100px
}
.album-cover {
    width:158px;
    height:158px;
}
');

?>
<div class="content">
    <div class="row">
        <div class="col-md-8">
            <div class="album-all">
                <div class="panel panel-default">
                    <div class="panel-heading"><?= Yii::t('app', 'Albums') ?></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="album-item col-md-2 col-sm-6">
                                <div class="album-img">
                                    <a href="<?= Url::toRoute(['/explore/create', 'category' => 'album']) ?>">
                                        <span class="add-album"><span class="glyphicon glyphicon-plus"></span></span>
                                    </a>
                                </div>
                            </div>
                            <?php foreach($albums as $album): ?>
                                <div class="album-item col-md-2 col-sm-6">
                                    <div class="album-img">
                                        <span>Album Id: <?= $album['table_id'] ?></span>
                                        <br>
                                        <a href="<?= Url::toRoute(['/explore/delete', 'id' => $album['id'], 'category' => 'album']) ?>" data-confirm="<?= Yii::t('app', 'Are you sure to delete it?') ?>" data-method="post">
                                            <span class="glyphicon glyphicon-remove"></span> <?= Yii::t('app', 'Delete') ?>
                                        </a>
                                        <a href="<?= Url::toRoute(['/explore/update', 'id' => $album['id'], 'category' => 'album']) ?>">
                                            <span class="glyphicon glyphicon-pencil"></span> <?= Yii::t('app', 'Edit') ?>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="timeline">
                <li class="time-label">
                    <?= Html::a(Yii::t('app', 'Create a post'), ['/explore/create', 'category' => 'post'], ['class' => 'btn btn-success']) ?>
                </li>
                <?php foreach($posts as $post): ?>
                    <li>
                        <i class="glyphicon glyphicon-list-alt bg-blue"></i>
                        <div class="timeline-item">
                            <span class="time">2015-06-05</span>
                            <h3 class="timeline-header"><span class="new-icon"></span>
                                <a href="<?= Url::toRoute(['/explore/view', 'id' => $post['id']]) ?>" title="?" target="_blank"><?= Html::encode($post['title']) ?></a>
                            </h3>
                            <div class="timeline-body">
                                <p><?= Html::encode($post['summary']) ?> ... </p>
                            </div>
                            <div class="timeline-footer">
                                <a class="btn btn-primary btn-xs" href="<?= Url::toRoute(['/explore/view', 'id' => $post['id']]) ?>" target="_blank"><?= Yii::t('app', 'Read more') ?></a>
                                <a class="btn btn-danger btn-xs"  href="<?= Url::toRoute(['/explore/delete', 'id' => $post['id']]) ?>" data-confirm="<?= Yii::t('app', 'Are you sure to delete it?') ?>" data-method="post">
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
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Yii::t('app', 'Recommendation') ?></h3>
                </div>
                <div class="panel-body">
                    <div class="list-group">
                        <?php foreach($forums as $forum): ?>
                            <a class="list-group-item" href="<?= Url::toRoute(['/explore/view', 'id' => $forum['id']]) ?>">
                                <h4 class="media-heading"><?= Html::encode($forum['forum_name']) ?></h4>
                            </a>
                        <?php endforeach ?>
                        <a class="list-group-item" href="<?= Url::toRoute(['/explore/create', 'category' => 'forum']) ?>">
                            <span class="glyphicon glyphicon-plus"></span> <?= Yii::t('app', 'Add Recommendation') ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
