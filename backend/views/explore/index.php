<?php

use yii\helpers\Html;
use yii\helpers\Url;
use shiyang\infinitescroll\InfiniteScrollPager;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Explore');
$this->registerCss('
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
            <div class="post-all">
                <?= Html::a(Yii::t('app', 'Create a post'), ['/explore/create', 'category' => 'post'], ['class' => 'btn btn-success']) ?>
                <?php foreach($posts as $post): ?>
                    <div class="post-list">
                        <h2 class="heading"><span class="new-icon"></span>
                            <a href="<?= Url::toRoute(['/explore/view', 'id' => $post['id']]) ?>" title="?" target="_blank"><?= Html::encode($post['title']) ?></a>
                        </h2>
                        <div class="info"> <span>2015-06-05</span> <span><i class="icons th-list-icon"></i><span class="hidden"> </div>
                        <div class="main row-fluid">
                            <div class="desc pull-left">
                                <p><?= Html::encode($post['summary']) ?> ... </p>
                                <a class="pull-right" href="<?= Url::toRoute(['/explore/delete', 'id' => $post['id']]) ?>" data-confirm="<?= Yii::t('app', 'Are you sure to delete it?') ?>" data-method="post">
                                    <span class="glyphicon glyphicon-trash"></span> <?= Yii::t('app', 'Delete') ?>
                                </a>
                                <span class="more pull-right"><a href="<?= Url::toRoute(['/explore/view', 'id' => $post['id']]) ?>" target="_blank">查看详情</a></span>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                <?php endforeach ?>
                <?= InfiniteScrollPager::widget([
                    'pagination' => $pages,
                    'widgetId' => '.post-all',
                ]);?>
            </div>
        </div>
        <div class="col-md-4">
            <p class="bg-success" style="padding:15px;">
                <b><?= Yii::t('app', 'Recommendation') ?></b>
            </p>
            <a href="<?= Url::toRoute(['/explore/create', 'category' => 'forum']) ?>" style=" border-bottom: 1px dotted #ccc;">
                <?= Yii::t('app', 'Add Recommendation') ?>
            </a>
            <?php foreach($forums as $forum): ?>
                <a href="<?= Url::toRoute(['/explore/view', 'id' => $forum['id']]) ?>" style=" border-bottom: 1px dotted #ccc;">
                    <div class="media">
                        <div class="media-body">
                            <h4 class="media-heading"><?= Html::encode($forum['forum_name']) ?></h4>
                        </div>
                    </div>
                </a>
            <?php endforeach ?>
        </div>
    </div>
</div>
