<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\modules\home\models\Album;
use shiyang\infinitescroll\InfiniteScrollPager;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['title'] = Yii::t('app', 'Explore');
?>
<div class="content">
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
                <?php foreach($posts['result'] as $post): ?>
                  <section class="post-list">
                    <div class="row">
                      <span class="titleimg col-md-3 hidden-xs">
                        <a href="<?= Url::toRoute(['/explore/view-post', 'id' => $post['id']]) ?>" target="_blank">
                          <?php
                            $pattern="/<[img|IMG].*?src=\"([^^]*?)\".*?>/"; 
                            preg_match_all($pattern,$post['content'], $match);
                            if (!empty($match[1][0])) {
                              echo \yii\helpers\Html::img($match[1][0], ['style'=>'max-width:100%;max-height:100%;']);
                            }
                          ?>
                        </a>
                      </span>
                      <div class="mecc col-md-9">
                        <a class="mecctitle" href="<?= Url::toRoute(['/explore/view-post', 'id' => $post['id']]) ?>" target="_blank">
                          <h2>
                              <?= Html::encode($post['title']) ?>
                          </h2>
                        </a>
                        <address class="meccaddress">
                          <time><span class="glyphicon glyphicon-time"></span> <?= Yii::$app->tools->formatTime($post['created_at']) ?></time>
                          - 
                          <?php
                            if (!empty($post['author'])) {
                              echo Html::a('<span class="glyphicon glyphicon-user"></span> ' . Html::encode($post['author']), ['/user/view', 'id' => $post['author']]);
                            } else {
                              echo '<span class="glyphicon glyphicon-user"></span> ' . Html::encode($post['username']);
                            }
                          ?>
                          -
                          <span title="<?= Yii::t('app', 'View Count') ?>"><span class="glyphicon glyphicon-eye-open"></span> <?= $post['view_count'] ?></span>
                        </address>
                        <p class="hidden-xs"><?= Html::encode($post['summary']) ?> ... </p>
                      </div>
                    </div>
                    <div class="clearfix"></div>
                  </section>
                <?php endforeach ?>
                <?= InfiniteScrollPager::widget([
                    'pagination' => $posts['pages'],
                    'widgetId' => '.post-all',
                ]);?>
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
            <?php foreach($forums['result'] as $forum): ?>
              <div class="media recommend-forum" onclick="window.location.href='<?= Url::toRoute(['/forum/forum/view', 'id' => $forum['forum_url']]) ?>';return false">
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
</div>
