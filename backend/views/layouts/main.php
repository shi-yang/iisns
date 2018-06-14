<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use backend\assets\AdminLteAsset;
use common\widgets\Alert;
use backend\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
AdminLteAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <?php $this->head() ?>
    </head>
    <body class="sidebar-mini" style="height: auto">
    <?php $this->beginBody() ?>
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Messages Dropdown Menu -->
                <li class="nav-item">
                    <a class="nav-link" href="<?= Url::toRoute(['/site/logout']) ?>">
                        <i class="fa fa-comments-o"></i>
                        <?= Yii::t('app', 'Logout') ?>
                    </a>
                </li>
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4" style="min-height: 846px;">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">
                <img src="<?= Yii::getAlias('@web/images/logo.jpg') ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Backend</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="info color-palette bg-success">
                        Hello, <a href="#"><?= Yii::$app->user->identity->username ?></a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
                             with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="<?= Url::toRoute(['/site/index']) ?>" class="nav-link">
                                <i class="nav-icon fa fa-dashboard"></i>
                                <p>
                                    <?= Yii::t('app', 'Dashboard'); ?>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= Url::toRoute(['/explore/index']) ?>" class="nav-link">
                                <i class="nav-icon fa fa-th"></i>
                                <p>
                                    <?= Yii::t('app', 'Explore') ?>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= Url::toRoute(['/setting/default']) ?>" class="nav-link">
                                <i class="nav-icon fa fa-th"></i>
                                <p>
                                    <?= Yii::t('app', 'Setting') ?>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa fa-pie-chart"></i>
                                <p>
                                    <?= Yii::t('app', 'Content') ?>
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= Url::toRoute(['/user']) ?>" class="nav-link">
                                        <i class="fa fa-users nav-icon"></i>
                                        <p><?= Yii::t('app', 'User') ?></p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= Url::toRoute(['/forum/forum/index']) ?>" class="nav-link">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p><?= Yii::t('app', 'Forum') ?></p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= Url::toRoute(['/post/index']) ?>" class="nav-link">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p><?= Yii::t('app', 'Blog') ?></p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="<?= Url::toRoute(['/rbac']) ?>" class="nav-link">
                                <i class="nav-icon fa fa-th"></i>
                                <p>
                                    <?= Yii::t('app', 'RBAC') ?>
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <div class="content-wrapper" style="min-height: 846px;">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <h1>
                        <?= \Yii::$app->controller->module->id ?>
                    </h1>
                    <?= Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                        'options' => ['class' => 'breadcrumb float-sm-right'],
                        'tag' => 'ol',
                        'itemTemplate' => '<li class="breadcrumb-item">{link}</li>',
                        'activeItemTemplate' => '<li class="breadcrumb-item active">{link}</li>'
                    ]) ?>
                </div>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <?= Alert::widget() ?>
                    <?= $content ?>
                </div>
            </section><!-- /.content -->
        </div><!-- /.right-side -->
    </div>
    <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>

