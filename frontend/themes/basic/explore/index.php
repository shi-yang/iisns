<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\modules\home\models\Album;
use app\components\Tools;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['title'] = Yii::t('app', 'Explore');
$this->registerCss('
a {
  color: #FF7B4C;
  text-decoration: none;
}
a:hover {
  color: #ff7e51;
  text-decoration: none;
}
.content {
  margin: 0 auto;
  margin-bottom: 20px;
  padding: 20px;
  background: #fff;
  box-shadow: 0 0 3px 1px rgba(0,0,0,0.05),0 1px 2px 0 rgba(0,0,0,0.1);
}
.recommend {
  margin-bottom: 20px;
  padding-bottom: 30px;
  border-bottom: 1px solid #ddd;
}
.carousel .item {
  height: 184px;
  width: 100%;
  background-color: #777;
}
.carousel-inner > .item > img {
  position: absolute;
  top: 0;
  left: 0;
  min-width: 100%;
  height: 184px;
}
.carousel-indicators {
  bottom: -30px;
}
.carousel-indicators .active {
    background-color: #CFCFCF;
}
.carousel-indicators li {
  border: 1px solid #C3C3C3;
}
.heading a {
  font-size: 18px;
  font-weight: bold;
  color: #FF7B4C;
  padding-right: 25px;
  background-position: center right;
  right: 0px;
  transition: all 0.5s ease-out;
  text-decoration: none;
}
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
.album-cover {
    width:158px;
    height:158px;
}
');
?>
<div class="content">
    <div class="recommend">
        <!-- Carousel ================================================== -->
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <img class="first-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="First slide">
                    <div class="container">
                        <div class="carousel-caption">
                            <h1>Example headline.</h1>

                        </div>
                    </div>
                </div>
                <div class="item">
                    <img class="second-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Second slide">
                    <div class="container">
                        <div class="carousel-caption">
                            <h1>Another example headline.</h1>

                        </div>
                    </div>
                </div>
                <div class="item">
                    <img class="third-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Third slide">
                    <div class="container">
                        <div class="carousel-caption">
                            <h1>One more for good measure.</h1>

                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.carousel -->
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="album-all">
                <div class="panel panel-default">
                    <div class="panel-heading">
                      <?= Yii::t('app', 'Albums') ?>
                      <?= Html::a(Yii::t('app', 'More'), ['/explore/photos'], ['class' => 'pull-right']) ?>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <?php
                            if ($this->beginCache('explore-album', ['duration' => 1])) {
                                foreach ($albums as $album) :
                                    $coverSrc = Album::getCoverPhoto($album['id']);
                                    $link = Url::toRoute(['/explore/view-album', 'id' => $album['id']]);
                                    ?>
                                    <div class="album-item col-md-2 col-sm-6">
                                        <div class="album-img">
                                            <a href="<?= $link ?>">
                                                <img src="<?= $coverSrc ?>" class="album-cover" alt="album-cover">
                                            </a>
                                        </div>
                                        <?= Html::a(Html::encode($album['name']), ['/explore/view-album', 'id' => $album['id']]) ?>
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
                    <div class="post-list">
                        <h2 class="heading">
                            <a href="<?= Url::toRoute(['/explore/view', 'id' => $post['id']]) ?>" title="<?= Html::encode($post['title']) ?>" target="_blank"><?= Html::encode($post['title']) ?></a>
                        </h2>
                        <div class="info">
                          <span class="glyphicon glyphicon-time"></span> <?= Tools::formatTime($post['created_at']) ?>
                          <?php
                            if (!empty($post['author'])) {
                              echo Html::a('<span class="glyphicon glyphicon-user"></span> ' . Html::encode($post['author']), ['/user/view', 'id' => $post['author']]);
                            } else {
                              echo '<span class="glyphicon glyphicon-user"></span> ' . Html::encode($post['username']);
                            }
                          ?>
                        </div>
                        <div class="main row-fluid">
                            <div class="desc pull-left">
                                <p><?= Html::encode($post['summary']) ?> ... </p>
                                <span class="more pull-right"><a href="<?= Url::toRoute(['/explore/view', 'id' => $post['id']]) ?>" target="_blank">查看详情</a></span>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                <?php endforeach ?>
            </div>
        </div>
        <div class="col-md-4">
            <?= \shiyang\login\Login::widget(['visible' => Yii::$app->user->isGuest]); ?>
            <p class="bg-success" style="padding:15px;">
                <b><?= Yii::t('app', 'Recommendation') ?></b>
                <?= Html::a(Yii::t('app', 'More'), ['/explore/forums'], ['class' => 'pull-right']) ?>
            </p>
            <?php foreach($forums['result'] as $forum): ?>
                <a href="<?= Url::toRoute(['/forum/forum/view', 'id' => $forum['forum_url']]) ?>" style="border-bottom: 1px dotted #ccc;">
                    <div class="media">
                        <div class="media-left">
                            <img class="media-object" style="height: 64px;width: 64px" src="<?= Yii::getAlias('@forum_icon') . $forum['forum_icon'] ?>" alt="<?= Html::encode($forum['forum_name']) ?>">
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading"><?= Html::encode($forum['forum_name']) ?></h4>
                            <?= Html::encode($forum['forum_desc']) ?>
                        </div>
                    </div>
                </a>
            <?php endforeach ?>
        </div>
    </div>
</div>
