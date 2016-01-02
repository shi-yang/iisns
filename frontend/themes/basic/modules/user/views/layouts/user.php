<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\widgets\Breadcrumbs;
use app\themes\basic\modules\user\AppAsset;
use frontend\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */
/* @var $user string */

$user = Yii::$app->user->identity;
$unReadMessageCount = $user->unReadMessageCount;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="<?= Yii::getAlias('@web') ?>/favicon.ico">
</head>
<body class="overflow-hidden layout-boxed">
    <?php $this->beginBody() ?>
    <div id="wrapper">
        <header id="top-nav" class="fixed skin-1">
            <a href="#" class="brand">
                <span><?= Yii::$app->setting->get('siteName') ?></span>
            </a><!-- /brand -->
            <button type="button" class="navbar-toggle pull-left" id="sidebarToggle">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <button type="button" class="navbar-toggle pull-left hide-menu" id="menuToggle">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <ul class="nav-notification clearfix">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="glyphicon glyphicon-bell"></i>
                        <span class="badge badge-danger notification-label bounceIn animation-delay4"><?= $unReadMessageCount  ?></span>
                    </a>
                    <ul class="dropdown-menu message dropdown-1">
                        <li><a>You have <?= $unReadMessageCount ?> new unread messages</a></li>
                        <li>
                            <a class="clearfix" href="#">
                                <img src="<?= Yii::getAlias('@avatar'). $user->avatar ?>" alt="User Avatar">
                                <div class="detail">
                                    <strong>John Doe</strong>
                                    <p class="no-margin">
                                        Lorem ipsum dolor sit amet...
                                    </p>
                                    <small class="text-muted"><i class="fa fa-check text-success"></i> 27m ago</small>
                                </div>
                            </a>
                        </li>
                        <li><a href="#">View all messages</a></li>
                    </ul>
                </li>
                <li class="profile dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <strong><?= Html::encode($user->username) ?></strong>
                        <span><i class="glyphicon glyphicon-chevron-down"></i></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="clearfix" href="#">
                                <img src="<?= Yii::getAlias('@avatar'). $user->avatar ?>" alt="User Avatar">
                                <div class="detail">
                                    <strong><?= Html::encode($user->username) ?></strong>
                                    <p class="grey"><?= Html::encode($user->email) ?></p>
                                </div>
                            </a>
                        </li>
                        <li><a tabindex="-1" href="<?= Url::toRoute(['/user/view', 'id' => $user->username]) ?>" class="main-link"><i class="glyphicon glyphicon-edit"></i> <?= Yii::t('app', 'Profile') ?></a></li>
                        <li><a tabindex="-1" href="<?= Url::toRoute(['/user/setting']) ?>" class="theme-setting"><i class="glyphicon glyphicon-cog"></i> <?= Yii::t('app', 'Setting') ?></a></li>
                        <li class="divider"></li>
                        <li><a tabindex="-1" class="main-link" data-toggle="modal" data-target="#logoutConfirm"><i class="glyphicon glyphicon-log-out"></i> <?= Yii::t('app', 'Log out') ?></a></li>
                    </ul>
                </li>
            </ul>
        </header><!-- /top-nav-->

        <aside class="fixed skin-1">
            <div class="sidebar-inner scrollable-sidebar" style="overflow: hidden; width: auto; height: 100%;">
                <div class="size-toggle">
                    <a class="btn btn-sm" id="sizeToggle">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <a class="btn btn-sm pull-right" data-toggle="modal" data-target="#logoutConfirm">
                        <i class="glyphicon glyphicon-off"></i>
                    </a>
                </div><!-- /size-toggle -->
                <div class="user-block clearfix">
                    <img src="<?= Yii::getAlias('@avatar'). $user->avatar ?>" alt="User Avatar">
                    <div class="detail">
                        <ul class="list-inline">
                            <li>
                                <a href="<?= Url::toRoute(['/user/view', 'id' => $user->username]) ?>" data-pjax="0">
                                    <i class="glyphicon glyphicon-new-window"></i> <strong><?= Html::encode($user->username) ?></strong>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div><!-- /user-block -->
                <div class="search-block">
                    <div class="input-group">
                        <input type="text" class="form-control input-sm" placeholder="search here...">
                    <span class="input-group-btn">
                        <button class="btn btn-default btn-sm" type="button"><i class="glyphicon glyphicon-search"></i></button>
                    </span>
                    </div><!-- /input-group -->
                </div><!-- /search-block -->
                <div class="main-menu">
                    <ul>
                        <li>
                            <a href="<?= Url::toRoute(['/user/dashboard']) ?>">
                            <span class="menu-icon">
                                <i class="glyphicon glyphicon-home"></i>
                            </span>
                            <span class="text">
                                <?= Yii::t('app', 'Home') ?>
                            </span>
                                <span class="menu-hover"></span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= Url::toRoute('/explore/index') ?>">
                            <span class="menu-icon">
                                <i class="glyphicon glyphicon-globe"></i>
                            </span>
                            <span class="text">
                                <?= Yii::t('app', 'Explore') ?>
                            </span>
                                <span class="menu-hover"></span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= Url::toRoute('/home/post') ?>">
                            <span class="menu-icon">
                                <i class="glyphicon glyphicon-list-alt"></i>
                            </span>
                            <span class="text">
                                <?= Yii::t('app', 'Blog') ?>
                            </span>
                                <span class="menu-hover"></span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= Url::toRoute('/home/album') ?>">
                            <span class="menu-icon">
                                <i class="glyphicon glyphicon-picture"></i>
                            </span>
                            <span class="text">
                                <?= Yii::t('app', 'Album') ?>
                            </span>
                                <span class="menu-hover"></span>
                            </a>
                        </li>
                        <!-- <li>
                            <a href="<?= Url::toRoute('/home/todu/music') ?>">
                            <span class="menu-icon">
                                <i class="glyphicon glyphicon-music"></i>
                            </span>
                            <span class="text">
                                <?= Yii::t('app', 'Music') ?>
                            </span>
                                <span class="menu-hover"></span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= Url::toRoute('/home/todu/video') ?>">
                            <span class="menu-icon">
                                <i class="glyphicon glyphicon-facetime-video"></i>
                            </span>
                            <span class="text">
                                <?= Yii::t('app', 'Video') ?>
                            </span>
                                <span class="menu-hover"></span>
                            </a>
                        </li> -->
                        <li>
                            <a href="<?= Url::toRoute(['/user/message']) ?>">
                            <span class="menu-icon">
                                <i class="glyphicon glyphicon-inbox"></i>
                            </span>
                            <span class="text">
                                <?= Yii::t('app', 'Notification') ?>
                            </span>
                                <span class="badge badge-danger bounceIn animation-delay6"><?= $unReadMessageCount ?></span>
                                <span class="menu-hover"></span>
                            </a>
                        </li>
                        <li>
                            <a href="http://www.iisns.com/forum/iisns">
                            <span class="menu-icon">
                                <i class="glyphicon glyphicon-question-sign"></i>
                            </span>
                            <span class="text">
                                <?= Yii::t('app', 'Help') ?>
                            </span>
                                <span class="menu-hover"></span>
                            </a>
                        </li>
                    </ul>
                </div><!-- /main-menu -->
            </div>
            <!-- /sidebar-inner -->
        </aside>
        <?php \yii\widgets\Pjax::begin(['linkSelector' => 'a']) ?>
        <div id="main-container">
            <div id="breadcrumb">
                <?= Breadcrumbs::widget([
                    'homeLink' => ['label' => Yii::t('app', 'Home'), 'url' => ['/user/dashboard']],
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
            </div><!-- /breadcrumb-->

            <div class="padding-md">
                <?= Alert::widget() ?>
                <div class="container-fluid">
                    <?= $content ?>
                </div>
            </div><!-- /.padding-md -->
        </div>
        <?php \yii\widgets\Pjax::end() ?>
        <footer>
            <div class="row">
                <div class="col-sm-6">
                    <p class="no-margin">
                        &copy; <?= date('Y') ?> <strong><?= Html::a(Yii::$app->setting->get('siteName'), ['/site/index']) ?></strong>. ALL Rights Reserved.
                        <div style="display: none"><?= Yii::$app->setting->get('statisticsCode') ?></div>
                    </p>
                </div><!-- /.col -->
            </div><!-- /.row-->
        </footer>
    </div>
    <div id="scroll-to-top"><span class="glyphicon glyphicon-menu-up"></span></div>
    <?php
      Modal::begin([
          'id' => 'logoutConfirm',
          'header' => '<h2>' . Yii::t('app', 'Log out') . '</h2>',
          'footer' => Html::a(Yii::t('app', 'Log out'), ['/site/logout'], ['class' => 'btn btn-default'])
      ]);
      echo Yii::t('app', 'Are you sure you want to Log out?');
      Modal::end();
    ?>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
