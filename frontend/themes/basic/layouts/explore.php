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
');
?>
<div class="wrap">
    <header id="header" class="hidden-xs">
        <div class="container">
            <div class="page-header">
                <h1><?= $this->params['title'] ?> <small><?= Yii::$app->setting->get('siteTitle') ?></small></h1>
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
            'label' => '<i class="glyphicon glyphicon-comment"></i> ' . Yii::t('app', 'Forums'),
            'url' => ['/explore/index'],
            'linkOptions' => ['data-pjax' => 0]
        ],
        [
            'label' => '<i class="glyphicon glyphicon-picture"></i> ' . Yii::t('app', 'Photos'),
            'url' => ['/explore/photos'],
            'linkOptions' => ['data-pjax' => 0]
        ],
        ['label' => '<i class="glyphicon glyphicon-list-alt"></i> ' . Yii::t('app', 'Posts'), 'url' => ['/explore/posts']],
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
