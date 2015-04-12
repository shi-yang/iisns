<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\themes\basic\modules\forum\AppAsset;
use frontend\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

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
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="modal-shiftfix wrap">
        <!-- Navigation -->
        <div class="navbar navbar-fixed-top scroll-hide">
            <div class="container-fluid top-bar visible-xs">
                <button class="navbar-toggle">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="logo" href="<?= Url::toRoute(['/forum/forum/view', 'id' => $this->params['forum']['forum_url']]) ?>"><?= Html::encode($this->params['forum']['forum_name']) ?></a>
            </div>
            <div class="container-fluid main-nav clearfix">
                <div class="nav-collapse ">
                    <div class="pull-left">
                        <div class="page-title">
                            <h1><?= Html::a(Html::encode($this->params['forum']['forum_name']), ['/forum/forum/view', 'id' => $this->params['forum']['forum_url']]) ?></h1>
                        </div>
                    </div>
                    <?php if (!Yii::$app->user->isGuest): ?>
                    <div class="pull-right" style="margin-top:6px">
                        <ul class="nav navbar-nav pull-right">
                            <li class="dropdown user hidden-xs"><a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                    <img width="34" height="34" src="<?= Yii::getAlias('@avatar'). Yii::$app->user->identity->avatar ?>" /><?= Yii::$app->user->identity->username ?><b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="<?= Url::toRoute(['/user/dashboard']) ?>">
                                            <i class="glyphicon glyphicon-user"></i><?= Yii::t('app', 'Personal Center') ?></a>
                                    </li>
                                    <li><a href="<?= Url::toRoute(['/user/setting']) ?>">
                                            <i class="glyphicon glyphicon-cog"></i><?= Yii::t('app', 'Setting') ?></a>
                                    </li>
                                    <li><a href="<?= Url::toRoute(['/site/logout']) ?>">
                                            <i class="glyphicon glyphicon-log-out"></i><?= Yii::t('app', 'Log out') ?></a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <?php endif ?>
                    <div class="pull-right">
                        <ul class="nav">
                            <li class="current">
                                <a href="<?= Url::toRoute(['/forum/forum/view', 'id' => $this->params['forum']['forum_url']]) ?>"><span aria-hidden="true" class="glyphicon glyphicon-home"></span><?= Yii::t('app', 'Home') ?></a>
                            </li>
                            <?php if ($this->params['forum']['user_id'] == Yii::$app->user->id): ?>
                            <li><a href="<?= Url::toRoute(['/forum/forum/update', 'id' => $this->params['forum']['forum_url']]) ?>">
                                    <span aria-hidden="true" class="glyphicon glyphicon-cog"></span><?= Yii::t('app', 'Setting') ?></a>
                            </li>
                            <?php endif; ?>
                            <li><a href="<?= Url::toRoute(['/forum/forum/broadcast', 'id' => $this->params['forum']['forum_url']]) ?>">
                                    <span aria-hidden="true" class="glyphicon glyphicon-volume-up"></span><?= Yii::t('app', 'Broadcast') ?></a>
                            </li>
                            <li><a href="<?= Url::toRoute(['/explore/index']) ?>">
                                    <span aria-hidden="true" class="glyphicon glyphicon-globe"></span><?= Yii::t('app', 'Explore') ?></a>
                            </li>
                            <?php if (Yii::$app->user->isGuest): ?>
                            <li><a href="<?= Url::toRoute(['/site/signup']) ?>">
                                    <span aria-hidden="true" class="glyphicon glyphicon-plus-sign"></span><?= Yii::t('app', 'Sign up') ?></a>
                            </li>
                            <li><a href="<?= Url::toRoute(['/site/login']) ?>">
                                    <span aria-hidden="true" class="glyphicon glyphicon-log-in"></span><?= Yii::t('app', 'Log in') ?></a>
                            </li>
                            <?php else: ?>
                            <li class="visible-xs"><a href="<?= Url::toRoute(['/user/dashboard']) ?>">
                                    <span aria-hidden="true" class="glyphicon glyphicon-user"></span><?= Yii::t('app', 'Personal Center') ?></a>
                            </li>
                            <li class="visible-xs"><a href="<?= Url::toRoute(['/site/logout']) ?>">
                                    <span aria-hidden="true" class="glyphicon glyphicon-log-out"></span><?= Yii::t('app', 'Log out') ?></a>
                            </li>
                            <?php endif ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Navigation -->
        <div class="container-fluid main-content">
            <div class="row">
                <div class="col-lg-12">
                    <?= Alert::widget() ?>
                </div>
            </div>
            <div class="row">
                <?= Breadcrumbs::widget([
                    'homeLink' => ['label' => Yii::t('app', 'Home'), 'url' => ['/forum/forum/view', 'id' => $this->params['forum']['forum_url']]],
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
                <?= $content ?>
            </div>
        </div>
    </div>
    <footer class="footer">
        <div class="container">
        <p class="pull-left">&copy; <?= Html::a(Yii::$app->setting->get('siteName'), ['/site/about']) ?> <?= date('Y') ?>
            <?= Html::a (' 中文简体 ', '?lang=zh-CN') . '| ' . 
            Html::a (' English ', '?lang=en') ;  
            ?>
        </p>
        <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>
    <?php $this->endBody() ?>
    <script type="text/javascript">
        $('.navbar-toggle').click(function() {
          return $('body, html').toggleClass("nav-open");
        });
    </script>
</body>
</html>
<?php $this->endPage() ?>
