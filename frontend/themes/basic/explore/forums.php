<?php

use yii\helpers\Html;
use shiyang\masonry\Masonry;

/* @var $this yii\web\View */

$this->params['title'] = Yii::t('app', 'Explore') . ' - ' . Yii::t('app', 'Forums');
$this->params['breadcrumb'][] = Yii::t('app', 'Forums');
$this->registerMetaTag(['name' => 'keywords', 'content' => Yii::$app->setting->get('siteKeyword')]);
$this->registerMetaTag(['name' => 'description', 'content' => Yii::$app->setting->get('siteDescription')]);
$this->registerCssFile(Yii::getAlias('@web').'/css/forum/css/forum.css');
?>
<div class="forum-index">
    <?php if (!Yii::$app->user->isGuest): ?>
        <p>
            <?= Html::a(Yii::t('app', 'Create Forum'), ['/forum/forum/create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php endif ?>

    <div class="forum-all">
        <?php Masonry::begin([
            'options' => [
              'id' => 'forums'
            ],
            'pagination' => $pages
        ]); ?>
            <?= $this->render('_forum', ['forums' => $forums, 'pages' => $pages]) ?>
        <?php Masonry::end(); ?>
    </div>
</div>
