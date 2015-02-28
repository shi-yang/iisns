<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;

/* @var $this yii\web\View */

$this->title = Yii::$app->setting->get('siteTitle');
$this->registerMetaTag(['name' => 'keywords', 'content' => Yii::$app->setting->get('siteKeyword')]);
$this->registerMetaTag(['name' => 'description', 'content' => Yii::$app->setting->get('siteDescription')]);
$this->registerCssFile(Yii::getAlias('@web').'/css/forum/css/forum.css');
?>
<div class="forum-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if (!Yii::$app->user->isGuest): ?>
        <p>
            <?= Html::a(Yii::t('app', 'Create Forum'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php endif ?>

    <div class="forum-all">
        <?php \yii2masonry\yii2masonry::begin([
            'clientOptions' => [
                'columnWidth' => 50,
                'itemSelector' => '.item'
            ]
        ]); ?>
        <?php foreach($forums as $model): ?>
            <div class="item" onclick="window.location.href= '<?= \yii\helpers\Url::toRoute(['/forum/forum/view', 'id' => $model['forum_url']]) ?>';return false">
              <div class="row">
                <img src="<?= Yii::getAlias('@forum_icon') . $model['forum_icon'] ?>" class="col-md-12 col-sm-12 col-xs-4">
                <div class="meta col-md-12 col-sm-8 col-xs-8">
                  <strong class="forum-name"><?= Html::encode($model['forum_name']); ?></strong>
                </div>
                <div class="forum-description col-md-12 col-sm-8 col-xs-8">
                  <?= Html::encode($model['forum_desc']); ?>
                </div>
              </div>
            </div>
        <?php endforeach; ?>
        <?php \yii2masonry\yii2masonry::end(); ?>
    </div>
</div>
