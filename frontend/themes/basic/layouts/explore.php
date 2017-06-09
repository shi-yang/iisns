<?php

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

if (!isset($this->title)) {
    $this->title = Yii::$app->setting->get('siteTitle');
}
if (Yii::$app->user->isGuest) {
    $this->beginContent(__DIR__.'/basic.php');
} else {
    $this->beginContent('@app/modules/user/views/layouts/user.php');
    $this->registerCssFile('@web/css/site.css');
    $this->registerCss('
        @media (min-width: 1200px) {
          .container {
            width: 970px;
          }
        }
    ');
}
$this->registerMetaTag(['name' => 'keywords', 'content' => Yii::$app->setting->get('siteKeyword')]);
$this->registerMetaTag(['name' => 'description', 'content' => Yii::$app->setting->get('siteDescription')]);
$this->registerCss('
    .wrap {background-color: #FFF;}
    .page-header {
        margin: 0;
    }
    .page-header .navbar-brand img {
        width: 178px;
        height: 52px;
    }
    .logo .brand {
        color: #666;
        font-size: 22px;
        float: left;
        padding-left: 10px;
        position: relative;
        top: 1px;
        border-left: 1px solid #eaeaea;
        margin-top: 15px;
        margin-left: 5px;
        overflow: hidden;
        height: 55px;
        line-height: 55px;
    }
    .navbar-nav .active>a .nav-highlight {
        -webkit-transform:scale(1);
        -ms-transform:scale(1);
        -o-transform:scale(1);
        transform:scale(1)
    }
    .navbar-nav > li > a:hover, .navbar-nav > li > a:focus {
        background-color: #EEE;
        -webkit-transform:scale(1);
        -ms-transform:scale(1);
        -o-transform:scale(1);
        transform:scale(1)
    }
    .navbar-nav a .nav-highlight {
        background: none repeat scroll 0 0 #4e6cef;
        border-top: 1px solid #2b1600;
        bottom: 0;
        height: 2px;
        left: 0;
        position: absolute;
        -moz-transform: scale(0,1);
        -webkit-transform: scale(0,1);
        -ms-transform: scale(0,1);
        -o-transform: scale(0,1);
        transform: scale(0,1);
        width: 100%;
    }
    .navbar-nav a, .navbar-nav a .nav-highlight {
        -webkit-backface-visibility: hidden;
        -moz-backface-visibility: hidden;
        backface-visibility: hidden;
        -webkit-transition: all .12s ease-in-out 0s;
        -o-transition: all .12s ease-in-out 0s;
        transition: all .12s ease-in-out 0s;
    }
    .navbar-nav a:hover .nav-highlight {
        -webkit-transform:scale(1);
        -ms-transform:scale(1);
        -o-transform:scale(1);
        transform:scale(1)
    }
');
?>
<div class="wrap">
    <header id="header" class="hidden-xs">
        <div class="container">
            <div class="page-header">
                <div class="logo pull-left">
                    <div class="pull-left">
                        <a class="navbar-brand" href="<?= Yii::$app->request->baseUrl ?>">
                            <img src="<?= Yii::getAlias('@web') ?>/images/logo.png" />
                        </a>
                    </div>
                    <div class="brand">
                        <?= $this->params['title'] ?> <small><?= Yii::$app->setting->get('siteTitle') ?></small>
                        <br />
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </header>
    <?php
    NavBar::begin([
        'options' => [
            'class' => 'navbar-default',
        ],
    ]);
    $menuItems = [
        [
            'label' => '<i class="glyphicon glyphicon-comment"></i> ' . Yii::t('app', 'Forums') . '<span class="nav-highlight"></span>',
            'url' => ['/explore/index'],
            'linkOptions' => ['data-pjax' => 0]
        ],
        [
            'label' => '<i class="glyphicon glyphicon-picture"></i> ' . Yii::t('app', 'Photos') . '<span class="nav-highlight"></span>',
            'url' => ['/explore/photos'],
            'linkOptions' => ['data-pjax' => 0]
        ],
        ['label' => '<i class="glyphicon glyphicon-list-alt"></i> ' . Yii::t('app', 'Posts') . '<span class="nav-highlight"></span>', 'url' => ['/explore/posts']],
    ];
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'encodeLabels' => false,
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>
    <div <?= (Yii::$app->user->isGuest) ? 'class="container"' : 'style="padding: 0 20px;"' ?> >
        <?= Breadcrumbs::widget([
            'homeLink' => ['label' => Yii::t('app', 'Explore'), 'url' => ['/explore/index']],
            'links' => isset($this->params['breadcrumb']) ? $this->params['breadcrumb'] : [],
        ]) ?>
        <?= $content; ?>
    </div>
</div>
<?php if (Yii::$app->user->isGuest): ?>
<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::a(Yii::$app->setting->get('siteName'), ['/site/index']) ?> <?= date('Y') ?>
            <?= Html::a (' 中文简体 ', '?lang=zh-CN') . '| ' . Html::a (' English ', '?lang=en'); ?>
        </p>
    </div>
</footer>
<?php endif; ?>
<?php $this->endContent(); ?>
