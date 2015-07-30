<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use app\modules\home\models\Album;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['title'] = Yii::t('app', 'Explore');
?>
<div class="row">
    <div class="col-md-8">
        <div class="e-album-all">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?= Yii::t('app', 'Albums') ?>
                    <?= Html::a(Yii::t('app', 'More'), ['/explore/photos'], ['class' => 'pull-right']) ?>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <?php
                            if ($this->beginCache('explore-album', ['duration' => 3600])) {
                                foreach ($albums as $album) :
                                    $coverSrc = Album::getCoverPhoto($album['id']);
                                    $link = Url::toRoute(['/explore/view-album', 'id' => $album['id']]);
                                    ?>
                                    <div class="album-item col-md-3 col-sm-6">
                                        <div class="album-img">
                                            <a href="<?= $link ?>">
                                                <img src="<?= $coverSrc ?>" class="album-cover" alt="album-cover">
                                            </a>
                                        </div>
                                        <div class="album-info">
                                            <?= Html::a(Html::encode($album['name']), ['/explore/view-album', 'id' => $album['id']]) ?>
                                        </div>
                                    </div>
                                <?php endforeach;
                                $this->endCache();
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="post-all">
            <?= $this->render('_post', [
                'posts' => $posts['result']
            ]) ?>
            <?= LinkPager::widget([
                'pagination' => $posts['pages']
            ]); ?>
        </div>
    </div>
    <div class="col-md-4">
        <?= \shiyang\login\Login::widget([
            'title' => Yii::t('app', 'Log in'),
            'visible' => Yii::$app->user->isGuest,
        ]); ?>
        <p class="bg-success" style="padding:15px;">
            <b><?= Yii::t('app', 'Recommendation') ?></b>
            <?= Html::a(Yii::t('app', 'More'), ['/explore/forums'], ['class' => 'pull-right']) ?>
        </p>
        <?php foreach ($forums['result'] as $forum): ?>
            <div class="media recommend-forum"
                 onclick="window.location.href='<?= Url::toRoute(['/forum/forum/view', 'id' => $forum['forum_url']]) ?>';return false">
                <div class="media-left">
                    <img class="media-object" style="height: 64px;width: 64px" src="<?= Yii::getAlias('@forum_icon') . $forum['forum_icon'] ?>" alt="<?= Html::encode($forum['forum_name']) ?>">
                </div>
                <div class="media-body">
                    <h4 class="media-heading"><?= Html::encode($forum['forum_name']) ?></h4>
                    <?= Html::encode($forum['forum_desc']) ?>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>
