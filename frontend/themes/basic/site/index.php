<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->title = Yii::$app->setting->get('siteTitle');
?>
<style type="text/css">
#version {
    margin-top: 22px;
    margin-bottom: 40px;
    font-size: 14px;
    line-height: 1.42857143;
    color: #515151;
    text-shadow: 0 1px 0 rgba(0, 0, 0, 0.15);
}
/* GLOBAL STYLES
-------------------------------------------------- */
/* Padding below the footer and lighter body text */

body {
  padding-bottom: 40px;
  color: #5a5a5a;
}


.wrap {
  background-color: #ffffff;
}
/* CUSTOMIZE THE NAVBAR
-------------------------------------------------- */

/* Special class on .container surrounding .navbar, used for positioning it into place. */
.navbar-wrapper {
  position: absolute;
  top: 0;
  right: 0;
  left: 0;
  z-index: 20;
}

/* Flip around the padding for proper display in narrow viewports */
.navbar-wrapper > .container {
  padding-right: 0;
  padding-left: 0;
}
.navbar-wrapper .navbar {
  padding-right: 15px;
  padding-left: 15px;
}
.navbar-wrapper .navbar .container {
  width: auto;
}


/* CUSTOMIZE THE CAROUSEL
-------------------------------------------------- */

/* Carousel base class */
.carousel {
  height: 500px;
}
/* Since positioning the image, we need to help out the caption */
.carousel-caption {
  z-index: 10;
}

/* Declare heights because of positioning of img element */
.carousel .item {
  height: 500px;
  background-color: #777;
}
.carousel-inner > .item > img {
  position: absolute;
  top: 0;
  left: 0;
  min-width: 100%;
  height: 500px;
}

.site-index {
  background-color: #fbfbfb;
  color: #999999;
  border-bottom: solid 2px #eeeeee;
}

.features-icon {
  font-size: 9em;
}

/* MARKETING CONTENT
-------------------------------------------------- */

/* Center align the text within the three columns below the carousel */
.marketing .col-lg-4 {
  margin-bottom: 20px;
  text-align: center;
}
.marketing h2 {
  font-weight: normal;
}
.marketing .col-lg-4 p {
  margin-right: 10px;
  margin-left: 10px;
}


/* Featurettes
------------------------- */

.featurette-divider {
  margin: 80px 0; /* Space out the Bootstrap <hr> more */
}

/* Thin out the marketing headings */
.featurette-heading {
  font-weight: 300;
  line-height: 1;
  letter-spacing: -1px;
}

.featurette-image {
  box-shadow: 0 0 0 4px #ffffff, 0 0 0 5px #e6e6e6;
}


/* RESPONSIVE CSS
-------------------------------------------------- */

@media (min-width: 768px) {
  /* Navbar positioning foo */
  .navbar-wrapper {
    margin-top: 20px;
  }
  .navbar-wrapper .container {
    padding-right: 15px;
    padding-left: 15px;
  }
  .navbar-wrapper .navbar {
    padding-right: 0;
    padding-left: 0;
  }

  /* The navbar becomes detached from the top, so we round the corners */
  .navbar-wrapper .navbar {
    border-radius: 4px;
  }

  /* Bump up size of carousel content */
  .carousel-caption p {
    margin-bottom: 20px;
    font-size: 21px;
    line-height: 1.4;
  }

  .featurette-heading {
    font-size: 50px;
  }
}

@media (min-width: 992px) {
  .featurette-heading {
    margin-bottom: 21px;
  }
}
</style>
<div class="wrap">
    <?php
        NavBar::begin([
            'brandLabel' => 'iiSNS',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-default navbar-fixed-top',
            ],
        ]);
        $menuItems = [
            ['label' => '<i class="glyphicon glyphicon-home"></i> ' . Yii::t('app', 'Home'), 'url' => ['/site/index']],
            ['label' => '<i class="glyphicon glyphicon-globe"></i> ' . Yii::t('app', 'Explore'), 'url' => ['/explore/index']],
        ];
        if (Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => '<i class="glyphicon glyphicon-plus-sign"></i> ' . Yii::t('app', 'Sign up'), 'url' => ['/site/signup']];
            $menuItems[] = ['label' => '<i class="glyphicon glyphicon-log-in"></i> ' . Yii::t('app', 'Log in'), 'url' => ['/site/login']];
        } else {
            $menuItems[] = ['label' => '<i class="glyphicon glyphicon-dashboard"></i> ' . Yii::t('app', 'Dashboard'), 'url' => ['/user/dashboard']];
            $menuItems[] = [
                'label' => '<i class="glyphicon glyphicon-log-out"></i> ' . Yii::t('app', 'Log out') . '(' . Yii::$app->user->identity->username . ')',
                'url' => ['/site/logout'],
                'linkOptions' => ['data-method' => 'post']
            ];
        }
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'encodeLabels' => false,
            'items' => $menuItems,
        ]);
        NavBar::end();
    ?>

    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner" role="listbox">
            <div class="item active">
                <img class="second-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Second slide">
                <div class="container">
                    <div class="carousel-caption">
                        <h1>iiSNS - 地球村入口</h1>
                        <p>iiSNS 是基于 yii2 的 SNS 社区系统，一站式解决社区建站。可以写文章，做记录，上传图片，论坛聊天等。还可以用来做内容管理系统（CMS）。iiSNS 是一个免费的开源项目，在 MIT 许可证下授权发布。</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="site-index">
        <div class="jumbotron">
            <h1><?= Yii::t('app', 'Everyone is an artist') ?></h1>
            <p class="lead">I hope you like it.</p>
            <p><a class="btn btn-lg btn-success" href="https://github.com/shi-yang/iisns/archive/v2.1.3.zip"><span class="glyphicon glyphicon-download-alt"></span> <?= Yii::t('app', 'Download Source') ?></a></p>
            <p id="version">
              Version 2.1.3 Alpha &nbsp;&nbsp;·&nbsp;&nbsp;
              <a href="https://github.com/shi-yang/iisns" target="_blank">
                GitHub Project</a> &nbsp;&nbsp;·&nbsp;&nbsp;
              Created by <a href="http://www.iisns.com/u/shiyang" target="_blank">Shiyang</a>
            </p>
        </div>
    </div>

    <!-- Marketing messaging and featurettes
    ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->

    <div class="container marketing">

        <!-- Three columns of text below the carousel -->
        <div class="row">
            <div class="col-lg-4">
                <span class="glyphicon glyphicon-comment features-icon"></span>
                <h2>粉丝营销社区</h2>
            </div><!-- /.col-lg-4 -->
            <div class="col-lg-4">
                <span class="glyphicon glyphicon-bullhorn features-icon"></span>
                <h2>新媒体行业</h2>
            </div><!-- /.col-lg-4 -->
            <div class="col-lg-4">
                <span class="glyphicon glyphicon-user features-icon"></span>
                <h2>企业文化建设</h2>
            </div><!-- /.col-lg-4 -->
        </div><!-- /.row -->


        <!-- START THE FEATURETTES -->

        <hr class="featurette-divider">

        <div class="row featurette">
            <div class="col-md-7">
                <h3 class="featurette-heading">易于使用 <span class="text-muted">无论是安装，还是开发</span></h3>
                <p class="lead">丰富的扩展插件，强大的开发社区支持。模块化，丰富的特性。</p>
            </div>
            <div class="col-md-5">
                <img class="featurette-image img-responsive img-circle center-block" src="<?= Yii::getAlias('@web/images/pic01.jpg') ?>" alt="Generic placeholder image">
            </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette">
            <div class="col-md-7 col-md-push-5">
                <h3 class="featurette-heading">功能丰富 <span class="text-muted">简而不繁</span></h3>
                <p class="lead">做记录，写文章，传图片，听音乐，看视频。还可以用来做论坛，内容管理系统。每一个功能，每一个页面，都尽己所能，使其臻于完美。</p>
            </div>
            <div class="col-md-5 col-md-pull-7">
                <img class="featurette-image img-responsive img-circle center-block" src="<?= Yii::getAlias('@web/images/pic02.jpg') ?>" alt="Generic placeholder image">
            </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette">
            <div class="col-md-7">
                <h3 class="featurette-heading">参与开发 <span class="text-muted">您参与iisns的发展是非常欢迎的！</span></h3>
                <p class="lead">目前还在不断完善中，如果您喜欢它，可以来
                  <a href="https://github.com/shi-yang/iisns/issues" target="_blank">帮助报告问题</a> ，
                  <a href="http://www.iisns.com/forum/iisns" target="_blank">提供反馈意见或设计讨论</a>，
                  <a href="https://github.com/shi-yang/iisns" target="_blank">贡献核心代码或修复的bug</a>。让它越来越棒。
                </p>
            </div>
            <div class="col-md-5">
                <img class="featurette-image img-responsive img-circle center-block" src="<?= Yii::getAlias('@web/images/pic03.jpg') ?>" alt="Generic placeholder image">
            </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette">
            <div class="col-md-7">
                <p class="lead">本程序在<a href="https://github.com/shi-yang/iisns/blob/master/LICENSE.md" target="_blank">MIT开源软件许可协议</a>下发布。</p>
            </div>
        </div>

        <hr class="featurette-divider">
    <!-- /END THE FEATURETTES -->
    </div><!-- /.container -->


</div>
<footer class="footer">
    <div class="container">
    <p class="pull-left">&copy; <?= Html::a(Yii::$app->setting->get('siteName'), ['/site/index']) ?> <?= date('Y') ?>
        <?= Html::a (' 中文简体 ', '?lang=zh-CN') . '| ' . 
        Html::a (' English ', '?lang=en') ;  
        ?>
    </p>
    <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>
